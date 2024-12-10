<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use MongoDB;
use MongoDB\Laravel\Eloquent\Builder;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

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
                    if (Arr::get($row, 'operator') === 'between') {
                        $query = $this->addWhere(
                            $query,
                            Arr::get($row, 'column'),
                            Arr::get($row, 'operator'),
                            $this->parseValue(Arr::get($row, 'from'), Arr::get($row, 'columnType')),
                            $this->parseValue(Arr::get($row, 'to'), Arr::get($row, 'columnType'))
                        );
                    } else {
                        $query = $this->addWhere(
                            $query,
                            Arr::get($row, 'column'),
                            Arr::get($row, 'operator'),
                            $this->parseValue(Arr::get($row, 'value'), Arr::get($row, 'columnType'))
                        );
                    }
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

    private function addWhere(Builder $query, $column, $operator, $value, $value2 = null)
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
            case 'between':
                return $query->whereBetween($column, [$value, $value2]);
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
        /** @var MongoDB\Database $mongoDB */
        $mongoDB = \DB::connection('mongodb')->getMongoDB();
        $collection = $mongoDB->selectCollection((new CrmCardMongo)->getTable());

        if (Arr::first(Arr::get($elements, '0.subelements'))) {
            return $this->getQuery($elements)->count();
        } else {
            return $collection->estimatedDocumentCount();
        }
    }

    public function getMql($elements)
    {
        return json_encode($this->getQuery($elements)->toMql());
    }
}
