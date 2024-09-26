<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class TargetGroupSelector
{
    public function getQueryFilters($elements, $root = true)
    {
        $filters = [];
        foreach ($elements as $row) {
            if (Arr::get($row, 'type') == 'rule') {
                if ($filter = TargetGroupSelectorFacade::getFilter($row)) {
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
                return '('.implode(' || ', $filters).')';
            } else {
                return '('.implode(' && ', $filters).')';
            }
        }

        return null;
    }

    public function getQuery($elements, $perPage = 10)
    {
        return CrmCard::search('*')
            ->options([
                'page' => 0,
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
        } else {
            $value = Arr::get($filter, 'value');
        }

        if (Arr::get($filter, 'column') && Arr::get($filter, 'operator') && ($value !== null) && ($value !== '')) {

            if (Str::contains(Arr::get($filter, 'column'), '.')) {
                $columnCollection = explode('.', Arr::get($filter, 'column'));
                $filter = '$'.$columnCollection[0].'_'.Auth::user()->currentEnvironmentId.'('.$columnCollection[1].':'.$this->generateComparison(Arr::get($filter, 'operator'), $value, Arr::get($filter, 'columnType')).')';
            } else {
                $filter = Arr::get($filter, 'column').':'.$this->generateComparison(Arr::get($filter, 'operator'), $value, Arr::get($filter, 'columnType'));
            }

            return $filter;
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
                    return '['.$value.']';
                case 'dnc':
                    return '!['.$value.']';
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
                return '['.(int) $value['from'].'..'.(int) $value['to'].']';
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
