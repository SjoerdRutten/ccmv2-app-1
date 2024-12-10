<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use MongoDB\Laravel\Eloquent\Builder;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use Spatie\Tags\Tag;

class TargetGroupSelectorMongo
{
    public function getQueryFilters(\MongoDB\Laravel\Eloquent\Builder $query, $elements)
    {
        foreach ($elements as $row) {
            if ((Arr::get($row, 'type') == 'block') && (count(Arr::get($row, 'subelements')))) {
                if ($row['operation'] === 'AND') {
                    $query->where(function ($query) use ($row) {
                        $this->getQueryFilters($query, $row['subelements']);
                    });
                } elseif ($row['operation'] === 'OR') {
                    $query->orWhere(function ($query) use ($row) {
                        $this->getQueryFilters($query, $row['subelements']);
                    });
                }
            } elseif ((Arr::get($row, 'type') == 'rule') && Arr::get($row, 'active')) {
                if (Arr::get($row, 'columnType') === 'target_group') {
                    $targetGroup = TargetGroup::find(Arr::get($row, 'value'));
                    $this->getQueryFilters($query, $targetGroup->filters);
                } else {
                    $query = $this->addWhere($query, Arr::get($row, 'column'), Arr::get($row, 'operator'), $this->parseValue(Arr::get($row, 'value'), Arr::get($row, 'columnType')));
                }
            }
        }

        return $query;
    }

    private function parseValue($value, $columnType)
    {
        switch ($columnType) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'date':
                return Carbon::parse($value)->toIso8601String();
            default:
                return $value;
        }
    }

    private function addWhere(Builder $query, $column, $operator, $value)
    {
        switch ($operator) {
            case 'gt':
                return $query->where($column, '>', $value);
            case 'gte':
                return $query->where($column, '>=', $value);
            case 'lt':
                return $query->where($column, '<', $value);
            case 'lte':
                return $query->where($column, '<=', $value);
            case 'eq':
                return $query->where($column, '=', $value);
            case 'ne':
                return $query->where($column, '<>', $value);
            case 'con':
                return $query->where($column, 'like', '%'.$value.'%');
            case 'dnc':
                return $query->whereNot($column, 'like', '%'.$value.'%');
            case 'sw':
                return $query->where($column, 'like', $value.'%');
            case 'snw':
                return $query->whereNot($column, 'like', $value.'%');
            case 'ew':
                return $query->where($column, 'like', '%'.$value);
            case 'enw':
                return $query->whereNot($column, 'like', '%'.$value);
            case 'empty':
                return $query->whereNull($column)
                    ->orWhere($column, '');
            case 'notempty':
                return $query->whereNotNull($column)
                    ->where($column, '<>', '');
                //            case 'eqm':,
                //                return '=['.$value.']';
                //            case 'neqm':
                //                return '!=['.$value.']';
                //            case 'between':
                //                return '['.(int) Arr::get($value, 'from').'..'.(int) Arr::get($value, 'to').']';
            default:
                return $query->where($column, '=', $value);
        }
    }

    /**
     * Generate the CRM Card Query for obtaining the results
     */
    public function getQuery($elements): \MongoDB\Laravel\Eloquent\Builder
    {
        return $this->getQueryFilters(CrmCardMongo::query(), $elements);
    }

    /**
     * Returns the count of results of the query
     */
    public function count($elements): int
    {
        return $this->getQuery($elements)->count();
    }

    public function getMql($elements)
    {
        return json_encode($this->getQuery($elements)->toMql());
    }

    //    /**
    //     * Make a nested array for the selected rules, so a collection can be only be joined once
    //     */
    //    private function makeNestedRules(array $subelements): array
    //    {
    //        $filters = [];
    //
    //        foreach ($subelements as $subelement) {
    //
    //            if ($subelement) {
    //                if (Arr::get($subelement, 'column') !== 'target_group_id') {
    //                    $column = explode('.', $subelement['column']);
    //                    Arr::pull($column, count($column) - 1);
    //
    //                    if (count($column)) {
    //                        $key = implode('.', $column).'.ids';
    //                    } else {
    //                        $key = 'ids';
    //                    }
    //
    //                    if (! Arr::has($filters, $key)) {
    //                        Arr::set($filters, $key, []);
    //                    }
    //
    //                    Arr::set($filters, $key.'.'.count(Arr::get($filters, $key)), $subelement['id']);
    //                }
    //            }
    //        }
    //
    //        return $filters;
    //    }
    //
    //    /**
    //     * Create the filterstring for a block of rules
    //     */
    //    private function makeBlockFilters(array $nestedRules, array $subElements): string
    //    {
    //        $filters = [];
    //
    //        foreach (Arr::get($nestedRules, 'ids', []) as $id) {
    //            if ($filter = $this->makeFilter(Arr::first($subElements, function ($value) use ($id) {
    //                return $value['id'] == $id;
    //            }))) {
    //                $filters[] = $filter;
    //            }
    //        }
    //
    //        foreach (Arr::except($nestedRules, 'ids') as $key => $element) {
    //            $filters[] = $this->makePathFilter($key, $element, $subElements);
    //        }
    //
    //        return implode(' && ', Arr::whereNotNull($filters));
    //    }
    //
    //    /**
    //     * Create the filter string for a set of rules
    //     */
    //    private function makePathFilter(string $path, array $element, array $subElements): ?string
    //    {
    //        $pathName = '$'.$path.'_'.Auth::user()->currentEnvironmentId.'(%s)';
    //
    //        $filters = [];
    //
    //        if (Arr::has($element, 'ids') && count(Arr::get($element, 'ids'))) {
    //            foreach (Arr::get($element, 'ids') as $id) {
    //                if ($filter = $this->makeFilter(Arr::first($subElements, function ($value) use ($id) {
    //                    return $value['id'] == $id;
    //                }))) {
    //                    $filters[] = $filter;
    //                }
    //            }
    //        }
    //
    //        foreach (Arr::except($element, 'ids') as $key => $elm) {
    //            if ($filter = $this->makePathFilter($key, $elm, $subElements)) {
    //                $filters[] = $filter;
    //            }
    //        }
    //
    //        if (count($filters)) {
    //            return sprintf($pathName, implode(' && ', $filters));
    //        }
    //
    //        return null;
    //    }
    //
    //    /**
    //     * Create the filterstring of a rule
    //     *
    //     * @throws \Exception
    //     */
    //    private function makeFilter($rule): ?string
    //    {
    //        $comparison = $this->generateComparison(
    //            Arr::get($rule, 'operator'),
    //            $this->parseValue($rule),
    //            Arr::get($rule, 'columnType')
    //        );
    //
    //        $columns = explode('.', $rule['column']);
    //
    //        if ($comparison) {
    //            return Arr::last($columns).':'.$comparison;
    //        }
    //
    //        return null;
    //    }
    //
    //    /**
    //     * Pase the value to the desired format
    //     *
    //     * @return array|\ArrayAccess|float|int|mixed|string|null
    //     */
    //    private function parseValue($filter)
    //    {
    //        $value = Arr::get($filter, 'value');
    //
    //        if (Arr::get($filter, 'columnType') === 'date') {
    //            if (is_array($value)) {
    //                $value = Arr::map($value, function ($date) {
    //                    return Carbon::parse($date)->timestamp;
    //                });
    //            } else {
    //                try {
    //                    $value = Carbon::parse($value)->timestamp;
    //                } catch (\Exception $e) {
    //                }
    //            }
    //        } elseif (Arr::get($filter, 'columnType') === 'boolean') {
    //            $value = $value ? 'true' : 'false';
    //        } elseif (Arr::get($filter, 'columnType') === 'tag') {
    //            $ids = is_array($value) ? $value : [$value];
    //            $tags = Tag::whereIn('id', $ids)->pluck('name')->toArray();
    //
    //            $value = null;
    //            if (count($tags)) {
    //                $value = '['.implode(',', $tags).']';
    //            }
    //        }
    //
    //        return $value;
    //    }
    //
    //    /**
    //     * Generate the comparison for a rule
    //     *
    //     * @throws \Exception
    //     */
    //    private function generateComparison($operator, $value, $columnType): ?string
    //    {
    //        if (empty($value)) {
    //            return null;
    //        } elseif ($columnType === 'boolean') {
    //            return '='.$value;
    //        } elseif (($columnType === 'text_array') || ($columnType === 'integer_array')) {
    //            if (! is_array($value)) {
    //                $value = explode(',', $value);
    //            }
    //            $value = Arr::where($value, fn ($value) => ! empty($value));
    //
    //            if ($columnType === 'integer_array') {
    //                $value = Arr::map($value, fn ($value) => (int) $value);
    //            }
    //
    //            $valueWildcard = implode(',', Arr::map($value, fn ($value) => $value.'*'));
    //            $value = implode(',', $value);
    //
    //            switch ($operator) {
    //                case 'con':
    //                    return '['.$valueWildcard.']';
    //                case 'dnc':
    //                    return '!['.$valueWildcard.']';
    //                case 'eq':
    //                    return '='.$value;
    //                case 'eqm':
    //                    return '=['.$value.']';
    //                case 'neqm':
    //                    return '!=['.$value.']';
    //                default:
    //                    throw new \Exception('Unknown operator: '.$operator);
    //            }
    //        } elseif ($columnType === 'product_array') {
    //            if (is_array($value)) {
    //                $value = implode(',', $value);
    //            }
    //
    //            switch ($operator) {
    //                case 'eqm':
    //                    return '=['.$value.']';
    //                case 'neqm':
    //                    return '!=['.$value.']';
    //                default:
    //                    throw new \Exception('Unknown operator: '.$operator);
    //            }
    //        } elseif ($columnType === 'select') {
    //            if (is_array($value)) {
    //                $value = implode(',', $value);
    //            }
    //
    //            switch ($operator) {
    //                case 'con':
    //                    return '=['.$value.']';
    //                case 'dnc':
    //                    return '!=['.$value.']';
    //                case 'eq':
    //                    return '='.$value;
    //                case 'ne':
    //                    return '!='.$value;
    //                default:
    //                    throw new \Exception('Unknown operator: '.$operator);
    //            }
    //        }
    //
    //        switch ($operator) {
    //            case 'gt':
    //                return '>'.$value;
    //            case 'gte':
    //                return '>='.$value;
    //            case 'lt':
    //                return '<'.$value;
    //            case 'lte':
    //                return '<='.$value;
    //            case 'eq':
    //                return '='.$value;
    //            case 'ne':
    //                return '!='.$value;
    //            case 'eqm':
    //                return '=['.$value.']';
    //            case 'neqm':
    //                return '!=['.$value.']';
    //            case 'between':
    //                return '['.(int) Arr::get($value, 'from').'..'.(int) Arr::get($value, 'to').']';
    //            case 'con':
    //            case 'sw':
    //                return $value.'*';
    //            case 'dnc':
    //            case 'snw':
    //                return '!'.$value.'*';
    //            case 'ew':
    //                return $value;
    //            case 'enw':
    //                return '!'.$value;
    //            default:
    //                return '='.$value;
    //                throw new \Exception('Unknown operator: '.$operator);
    //        }
    //    }
}
