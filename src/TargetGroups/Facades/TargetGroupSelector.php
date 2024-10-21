<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use Spatie\Tags\Tag;

class TargetGroupSelector
{
    public function getQueryFilters($elements, $root = true)
    {
        $filters = [];
        foreach ($elements as $row) {
            if (Arr::get($row, 'type') == 'rule') {
                if ($filter = $this->getFilter($row)) {
                    $filters[] = $filter;
                }
            } elseif ((Arr::get($row, 'type') == 'block') && (count(Arr::get($row, 'subelements')))) {
                if ($filter = $this->getQueryFilters(Arr::get($row, 'subelements'), false)) {
                    $filters[] = $filter;
                }
            }
        }

        if (count($filters)) {
            if ($root) {
                $filterString = implode(' || ', $filters);
            } else {
                $filterString = implode(' && ', $filters);
            }

            if (count($filters) > 1) {
                $filterString = '('.$filterString.')';
            }

            return $filterString;
        }

        return null;
    }

    public function getQuery($elements, $perPage = 10, $page = 0)
    {
        return CrmCard::search('*')
            ->options([
                'page' => $page,
                'per_page' => $perPage,
                'filter_by' => $this->getQueryFilters($elements),
            ]);
    }

    public function count($elements)
    {
        if ($data = $this->getQuery($elements, 1)) {
            $data = $data->raw();

            return Arr::get($data, 'found');
        }

        return 0;
    }

    public function getFilter($filter): string|bool
    {
        if (Arr::get($filter, 'columnType') === 'date') {
            if (is_array(Arr::get($filter, 'value'))) {
                $value = Arr::map(Arr::get($filter, 'value'), function ($date) {
                    return Carbon::parse($date)->timestamp;
                });
            } else {
                $value = Carbon::parse(Arr::get($filter, 'value'))->timestamp;
            }
        } elseif (Arr::get($filter, 'columnType') === 'boolean') {
            $filter['operator'] = 'eq';
            $value = Arr::get($filter, 'value') ? 'true' : 'false';
        } elseif (Arr::get($filter, 'columnType') === 'target_group') {
            $value = Arr::get($filter, 'value');
        } elseif (Arr::get($filter, 'columnType') === 'tag') {
            $tags = Tag::whereIn('id', Arr::get($filter, 'value'))->pluck('name')->toArray();

            $value = null;
            if (count($tags)) {
                $value = '['.implode(',', $tags).']';
            }
        } else {
            $value = Arr::get($filter, 'value');
        }

        if (Arr::get($filter, 'column') && ($operator = Arr::get($filter, 'operator'))) {
            if ($operator === 'between') {
                if (filled(Arr::get($filter, 'from')) && filled(Arr::get($filter, 'to'))) {
                    if (Str::contains(Arr::get($filter, 'column'), '.')) {
                        $columnCollection = explode('.', Arr::get($filter, 'column'));

                        return '$'.$columnCollection[0].'_'.Auth::user()->currentEnvironmentId.'('.$columnCollection[1].':['.(int) Arr::get($filter, 'from').'..'.(int) Arr::get($filter, 'to').'])';
                    } else {
                        return Arr::get($filter, 'column').':['.(int) Arr::get($filter, 'from').'..'.(int) Arr::get($filter, 'to').']';
                    }
                }
            } elseif (filled($value)) {
                if (Arr::get($filter, 'columnType') == 'target_group') {
                    if ($targetGroup = TargetGroup::find(Arr::get($filter, 'value'))) {
                        return $this->getQueryFilters($targetGroup->filters);
                    }

                    return false;
                } elseif (Str::contains(Arr::get($filter, 'column'), '.')) {
                    $columnCollection = explode('.', Arr::get($filter, 'column'));

                    return '$'.$columnCollection[0].'_'.Auth::user()->currentEnvironmentId.'('.$columnCollection[1].':'.$this->generateComparison(Arr::get($filter, 'operator'), $value, Arr::get($filter, 'columnType')).')';
                } else {
                    return Arr::get($filter, 'column').':'.$this->generateComparison(Arr::get($filter, 'operator'), $value, Arr::get($filter, 'columnType'));
                }
            }
        }

        return false;
    }

    private function generateComparison($operator, $value, $columnType): string
    {
        if (in_array($columnType, ['text_array', 'select'])) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }

            switch ($operator) {
                case 'con':
                    return '=['.$value.']';
                case 'dnc':
                    return '!=['.$value.']';
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
            case 'between':
                return '['.(int) Arr::get($value, 'from').'..'.(int) Arr::get($value, 'to').']';
            case 'con':
                return '*'.$value.'*';
            case 'dnc':
                return '!*'.$value.'*';
            case 'sw':
                return $value.'*';
            case 'snw':
                return '!'.$value.'*';
            case 'ew':
                return '*'.$value;
            case 'enw':
                return '!*'.$value;
            default:
                throw new \Exception('Unknown operator: '.$operator);
        }
    }
}
