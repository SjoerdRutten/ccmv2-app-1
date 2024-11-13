<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Builder;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Spatie\Tags\Tag;

class TargetGroupSelector
{
    public function getQueryFilters($elements)
    {
        $filters = [];
        foreach ($elements as $row) {
            if ((Arr::get($row, 'type') == 'block') && (count(Arr::get($row, 'subelements')))) {
                $subElements = Arr::get($row, 'subelements');
                $nestedRules = $this->makeNestedRules($subElements);

                $filters[] = $this->makeBlockFilters($nestedRules, $subElements);
            }
        }

        if (count($filters)) {
            return implode(' || ', $filters);
        }

        return null;
    }

    /**
     * Generate the CRM Card Query for obtaining the results
     */
    public function getQuery($elements, $perPage = 10, $page = 0): Builder
    {
        return CrmCard::search('*')
            ->options([
                'page' => $page,
                'per_page' => $perPage,
                'filter_by' => $this->getQueryFilters($elements),
            ]);
    }

    /**
     * Returns the count of results of the query
     */
    public function count($elements): int
    {
        if ($data = $this->getQuery($elements, 1)) {
            $data = $data->raw();

            return Arr::get($data, 'found');
        }

        return 0;
    }

    /**
     * Make a nested array for the selected rules, so a collection can be only be joined once
     */
    private function makeNestedRules(array $subelements): array
    {
        $filters = [];

        foreach ($subelements as $subelement) {
            if ($subelement) {
                $column = explode('.', $subelement['column']);
                Arr::pull($column, count($column) - 1);

                if (count($column)) {
                    $key = implode('.', $column).'.ids';
                } else {
                    $key = 'ids';
                }

                if (! Arr::has($filters, $key)) {
                    Arr::set($filters, $key, []);
                }

                Arr::set($filters, $key.'.'.count(Arr::get($filters, $key)), $subelement['id']);
            }
        }

        return $filters;
    }

    /**
     * Create the filterstring for a block of rules
     */
    private function makeBlockFilters(array $nestedRules, array $subElements): string
    {
        $filters = [];

        foreach (Arr::get($nestedRules, 'ids', []) as $id) {
            if ($filter = $this->makeFilter(Arr::first($subElements, function ($value) use ($id) {
                return $value['id'] == $id;
            }))) {
                $filters[] = $filter;
            }
        }

        foreach (Arr::except($nestedRules, 'ids') as $key => $element) {
            $filters[] = $this->makePathFilter($key, $element, $subElements);
        }

        return implode(' && ', Arr::whereNotNull($filters));
    }

    /**
     * Create the filter string for a set of rules
     */
    private function makePathFilter(string $path, array $element, array $subElements): ?string
    {
        $pathName = '$'.$path.'_'.Auth::user()->currentEnvironmentId.'(%s)';

        $filters = [];

        if (Arr::has($element, 'ids') && count(Arr::get($element, 'ids'))) {
            foreach (Arr::get($element, 'ids') as $id) {
                if ($filter = $this->makeFilter(Arr::first($subElements, function ($value) use ($id) {
                    return $value['id'] == $id;
                }))) {
                    $filters[] = $filter;
                }
            }
        }

        foreach (Arr::except($element, 'ids') as $key => $elm) {
            if ($filter = $this->makePathFilter($key, $elm, $subElements)) {
                $filters[] = $filter;
            }
        }

        if (count($filters)) {
            return sprintf($pathName, implode(' && ', $filters));
        }

        return null;
    }

    /**
     * Create the filterstring of a rule
     *
     * @throws \Exception
     */
    private function makeFilter($rule): ?string
    {
        $comparison = $this->generateComparison(
            Arr::get($rule, 'operator'),
            $this->parseValue($rule),
            Arr::get($rule, 'columnType')
        );

        $columns = explode('.', $rule['column']);

        if ($comparison) {
            return Arr::last($columns).':'.$comparison;
        }

        return null;
    }

    /**
     * Pase the value to the desired format
     *
     * @return array|\ArrayAccess|float|int|mixed|string|null
     */
    private function parseValue($filter)
    {
        $value = Arr::get($filter, 'value');

        if (Arr::get($filter, 'columnType') === 'date') {
            if (is_array($value)) {
                $value = Arr::map($value, function ($date) {
                    return Carbon::parse($date)->timestamp;
                });
            } else {
                try {
                    $value = Carbon::parse($value)->timestamp;
                } catch (\Exception $e) {
                }
            }
        } elseif (Arr::get($filter, 'columnType') === 'boolean') {
            $value = $value ? 'true' : 'false';
        } elseif (Arr::get($filter, 'columnType') === 'tag') {
            $ids = is_array($value) ? $value : [$value];
            $tags = Tag::whereIn('id', $ids)->pluck('name')->toArray();

            $value = null;
            if (count($tags)) {
                $value = '['.implode(',', $tags).']';
            }
        }

        return $value;
    }

    /**
     * Generate the comparison for a rule
     *
     * @throws \Exception
     */
    private function generateComparison($operator, $value, $columnType): ?string
    {
        if (empty($value)) {
            return null;
        } elseif ($columnType === 'boolean') {
            return '='.$value;
        } elseif (($columnType === 'text_array') || ($columnType === 'integer_array')) {
            if (! is_array($value)) {
                $value = explode(',', $value);
            }
            $value = Arr::where($value, fn ($value) => ! empty($value));

            if ($columnType === 'integer_array') {
                $value = Arr::map($value, fn ($value) => (int) $value);
            }

            $valueWildcard = implode(',', Arr::map($value, fn ($value) => $value.'*'));
            $value = implode(',', $value);

            switch ($operator) {
                case 'con':
                    return '['.$valueWildcard.']';
                case 'dnc':
                    return '!['.$valueWildcard.']';
                case 'eq':
                    return '='.$value;
                case 'eqm':
                    return '=['.$value.']';
                case 'neqm':
                    return '!=['.$value.']';
                default:
                    throw new \Exception('Unknown operator: '.$operator);
            }
        } elseif ($columnType === 'product_array') {
            if (is_array($value)) {
                $value = implode(',', $value);
            }

            switch ($operator) {
                case 'eqm':
                    return '=['.$value.']';
                case 'neqm':
                    return '!=['.$value.']';
                default:
                    throw new \Exception('Unknown operator: '.$operator);
            }
        } elseif ($columnType === 'select') {
            if (is_array($value)) {
                $value = implode(',', $value);
            }

            switch ($operator) {
                case 'con':
                    return '=['.$value.']';
                case 'dnc':
                    return '!=['.$value.']';
                case 'eq':
                    return '='.$value;
                case 'ne':
                    return '!='.$value;
                default:
                    throw new \Exception('Unknown operator: '.$operator);
            }
        }

        switch ($operator) {
            case 'gt':
                return '>'.$value;
            case 'gte':
                return '>='.$value;
            case 'lt':
                return '<'.$value;
            case 'lte':
                return '<='.$value;
            case 'eq':
                return '='.$value;
            case 'ne':
                return '!='.$value;
            case 'eqm':
                return '=['.$value.']';
            case 'neqm':
                return '!=['.$value.']';
            case 'between':
                return '['.(int) Arr::get($value, 'from').'..'.(int) Arr::get($value, 'to').']';
            case 'con':
            case 'sw':
                return $value.'*';
            case 'dnc':
            case 'snw':
                return '!'.$value.'*';
            case 'ew':
                return $value;
            case 'enw':
                return '!'.$value;
            default:
                return '='.$value;
                throw new \Exception('Unknown operator: '.$operator);
        }
    }
}
