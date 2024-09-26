<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class TargetGroupSelector
{
    public function getFilter($filter): string|bool
    {
        // TODO: text_array toevoegen, dat moeten meerdere waarden kunnen worden

        if (Arr::get($filter, 'columnType') === 'date') {
            if (is_array(Arr::get($filter, 'value'))) {
                $value = \Arr::map(Arr::get($filter, 'value'), function ($date) {
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

            if (\Str::contains(Arr::get($filter, 'column'), '.')) {
                $columnCollection = explode('.', Arr::get($filter, 'column'));
                $filter = '$'.$columnCollection[0].'_'.\Auth::user()->currentEnvironmentId.'('.$columnCollection[1].':'.$this->generateComparison(Arr::get($filter, 'operator'), $value, Arr::get($filter, 'columnType')).')';
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
