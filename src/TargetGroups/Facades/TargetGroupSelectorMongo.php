<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use MongoDB;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class TargetGroupSelectorMongo
{
    public function getQueryFilters($query, $elements)
    {
        if ($orderElements = Arr::where($elements, fn ($item) => \Str::startsWith(Arr::get($item, 'column'), 'orders.'))) {
            $query->whereHas('orders', function ($query) use ($orderElements) {
                foreach ($orderElements as $row) {

                    $column = explode('.', Arr::get($row, 'column'));
                    Arr::forget($column, 0);
                    $column = implode('.', $column);

                    $query = $this->addWhere(
                        $query,
                        $column,
                        Arr::get($row, 'operator'),
                        $this->parseValue(Arr::get($row, 'value'), Arr::get($row, 'columnType'), Arr::get($row, 'operator'))
                    );
                }
            });
        }

        foreach (Arr::where($elements, fn ($item) => ! \Str::startsWith(Arr::get($item, 'column'), 'orders')) as $row) {// Blocks
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
                // Rules
            } elseif ((Arr::get($row, 'type') == 'rule') && Arr::get($row, 'active') && (Arr::get($row, 'value') || (Arr::get($row, 'columnType') === 'boolean') || (in_array(Arr::get($row, 'operator'), ['empty', 'notempty', 'between'])))) {
                // Sub-target-groups
                if (Arr::get($row, 'columnType') === 'target_group') {
                    if ($targetGroup = TargetGroup::find(Arr::get($row, 'value'))) {
                        if (Arr::get($row, 'operator') === 'eq') {
                            $this->getQueryFilters($query, $targetGroup->filters);
                        } else {
                            //                            $ids = $this->getQueryFilters(CrmCardMongo::query(), $targetGroup->filters)->select('id')->pluck('id')->toArray();
                            //                            $query->whereNotIn('_id', $ids);

                            $query->where(
                                function ($query) use ($targetGroup) {
                                    $this->getQueryFilters($query, $targetGroup->filters);
                                }
                            );

                        }
                    }
                } else {
                    if (Arr::get($row, 'operator') === 'between') {
                        $query = $this->addWhere(
                            $query,
                            Arr::get($row, 'column'),
                            Arr::get($row, 'operator'),
                            $this->parseValue(Arr::get($row, 'from'), Arr::get($row, 'columnType'), Arr::get($row, 'operator')),
                            $this->parseValue(Arr::get($row, 'to'), Arr::get($row, 'columnType'), Arr::get($row, 'operator'))
                        );
                    } else {
                        $query = $this->addWhere(
                            $query,
                            Arr::get($row, 'column'),
                            Arr::get($row, 'operator'),
                            $this->parseValue(Arr::get($row, 'value'), Arr::get($row, 'columnType'), Arr::get($row, 'operator'))
                        );
                    }
                }
            }
        }

        return $query;
    }

    private function parseValue($value, $columnType, $operator)
    {
        if ((in_array($operator, ['eqm', 'neqm'])) && (! is_countable($value))) {
            $value = explode(',', $value);
        }

        switch ($columnType) {
            case 'boolean':
                return (bool) $value;
            case 'select_integer':
            case 'integer':
                if (is_countable($value)) {
                    return Arr::map($value, function ($item) {
                        return (int) $item;
                    });
                }

                return (int) $value;
            case 'float':
                if (is_countable($value)) {
                    return Arr::map($value, function ($item) {
                        return (float) $item;
                    });
                }

                return (float) $value;
            case 'price':
                return (int) ($value * 100);
            case 'date':
                return Carbon::parse($value)->toIso8601String();
            case 'integer_array':
            case 'product_array':
                $value = is_array($value) ? $value : [$value];

                return Arr::map($value, function ($item) {
                    return (int) $item;
                });
            case 'text_array':
                return Arr::map($value, function ($item) {
                    return (string) $item;
                });

            default:
                return $value;
        }
    }

    private function addWhere($query, $column, $operator, $value, $value2 = null)
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
            case 'neq':
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
            case 'eqm':
                $value = is_countable($value) ? $value : [$value];

                return $query->whereIn($column, $value);
            case 'neqm':
                $value = is_countable($value) ? $value : [$value];

                return $query->whereNotIn($column, $value);
            case 'between':
                return $query->whereBetween($column, [$value, $value2]);
            default:
                return $query->where($column, '=', $value);
        }
    }

    /**
     * Generate the CRM Card Query for obtaining the results
     */
    public function getQuery($elements)
    {
        return $this->getQueryFilters(CrmCardMongo::query(), $elements);
    }

    /**
     * Returns the count of results of the query
     */
    public function count($elements, ?string $crmId = null): int
    {
        /** @var MongoDB\Database $mongoDB */
        $mongoDB = \DB::connection('mongodb')->getMongoDB();
        $collection = $mongoDB->selectCollection((new CrmCardMongo)->getTable());

        if ($crmId) {
            $uniqid = uniqid();
            $elements[] = [
                'id' => $uniqid,
                'type' => 'rule',
                'value' => $crmId,
                'column' => 'crm_id',
                'columnType' => 'text',
                'active' => true,
            ];
        }

        if (is_array($elements) &&
            Arr::get($elements, '0.subelements') &&
            Arr::whereNotNull(Arr::get($elements, '0.subelements'))
        ) {
            return $this->getQuery($elements)->count();
        } else {
            return $collection->estimatedDocumentCount();
        }
    }

    public function getMql($elements)
    {
        return json_encode(Arr::get($this->getQuery($elements)->toMql(), 'find.0'));
    }
}
