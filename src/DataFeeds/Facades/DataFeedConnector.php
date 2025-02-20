<?php

namespace Sellvation\CCMV2\DataFeeds\Facades;

use Sellvation\CCMV2\DataFeeds\Models\DataFeed;

class DataFeedConnector
{
    public function getOriginalFirstRow(int $dataFeedId): ?array
    {
        $dataFeed = $this->getDataFeed($dataFeedId);
        $data = $this->getDataFeedData($dataFeed);

        return \Arr::first($data);
    }

    public function getRow(int $dataFeedId, $reference, $referenceKey = null): ?array
    {
        $dataFeed = $this->getDataFeed($dataFeedId);
        $data = $this->getDataFeedData($dataFeed);

        if ($referenceKey = $referenceKey ?? $this->getReferenceKey($dataFeed)) {
            $cacheKey = 'datafeed.'.$dataFeedId.'.'.$reference.'.'.$referenceKey;

            if (\Cache::has($cacheKey)) {
                return \Cache::get($cacheKey);
            }

            $row = \Arr::first(\Arr::where($data, function ($row) use ($referenceKey, $reference) {
                return $row[$referenceKey] === $reference;
            }));
        } else {
            $row = null;
        }

        $returnRow = [];
        if ($row) {

            foreach ($dataFeed->data_config['fields'] as $key => $value) {
                if ($value['visible']) {
                    //                dd($value, $key, $value['key'] ?? $key);
                    $returnRow[$value['key'] ?? $key] = \Arr::get($row, $key);
                }
            }

            \Cache::add($cacheKey, $returnRow);
        }

        return $returnRow;
    }

    public function getOriginalKeys(int $dataFeedId): ?array
    {
        return $this->array_walk_keys($this->getOriginalFirstRow($dataFeedId));
    }

    public function getReferences(int $dataFeedId): ?array
    {
        $dataFeed = $this->getDataFeed($dataFeedId);
        $data = $this->getDataFeedData($dataFeed);
        $referenceKey = $this->getReferenceKey($dataFeed);

        if ($referenceKey) {

            $keys = \Arr::map($data, function ($row) use ($referenceKey) {
                return \Arr::get($row, $referenceKey);
            });

            $keys = array_unique($keys);
            sort($keys);

            return $keys;
        }

        return [];
    }

    private function getDataFeed(int $dataFeedId): DataFeed
    {
        return DataFeed::find($dataFeedId);
    }

    private function getDataFeedData(DataFeed $dataFeed): ?array
    {
        if (\Cache::has('datafeed.'.$dataFeed->id)) {
            return \Cache::get('datafeed.'.$dataFeed->id);
        }

        if ($dataFeed->data) {
            \Cache::add('datafeed.'.$dataFeed->id, $dataFeed->data);

            return $dataFeed->data;
        } else {
            return [];
        }
    }

    private function getReferenceKey(DataFeed $dataFeed): ?string
    {
        return \Arr::get($dataFeed->data_config, 'reference_key');
    }

    //    private function array_keys_recursive($myArray, $MAXDEPTH = INF, $depth = 0, $arrayKeys = [])
    //    {
    //        if ($depth < $MAXDEPTH) {
    //            $depth++;
    //            $keys = array_keys($myArray);
    //            foreach ($keys as $key) {
    //                if (is_array($myArray[$key])) {
    //                    $arrayKeys[$key] = $this->array_keys_recursive($myArray[$key], $MAXDEPTH, $depth);
    //                } else {
    //                    $arrayKeys[$key] = $key;
    //                }
    //            }
    //        }
    //
    //        return $arrayKeys;
    //    }

    public function array_walk_keys($array, $parentKey = null, &$flattened_array = null)
    {
        if (! is_array($array)) {
            return $array;
        }

        foreach ($array as $key => $val) {
            $flattenedKeysArray[] = $key;

            if (is_array($val)) {
                $this->array_walk_keys($val, $key, $flattenedKeysArray);
            }
        }

        return $flattenedKeysArray;
    }
}
