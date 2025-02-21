<?php

namespace Sellvation\CCMV2\DataFeeds\Facades;

use Arr;
use Sellvation\CCMV2\DataFeeds\Models\DataFeed;

class DataFeedConnector
{
    public function getValue(int $dataFeedId, ?string $reference, string $field)
    {
        if ($reference) {
            $data = $this->getRow($dataFeedId, $reference);
        } else {
            $data = $this->getFirstRow($dataFeedId);
        }

        return \Arr::get($data, $field);
    }

    public function getOriginalFirstRow(int $dataFeedId): ?array
    {
        if ($dataFeed = $this->getDataFeed($dataFeedId)) {
            $data = $this->getDataFeedData($dataFeed);

            return \Arr::first($data);
        }

        return [];
    }

    public function getFirstRow(int $dataFeedId): ?array
    {
        $dataFeed = $this->getDataFeed($dataFeedId);
        $data = $this->getOriginalFirstRow($dataFeedId);

        return $this->mapData($dataFeed, $data);
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

        if ($row) {
            $row = $this->mapData($dataFeed, $row);
            \Cache::add($cacheKey, $row);
        }

        return $row;
    }

    private function mapData($dataFeed, $row)
    {
        $returnRow = [];
        if ($row && Arr::get($dataFeed->data_config, 'fields')) {

            foreach ($dataFeed->data_config['fields'] as $key => $value) {
                if ($value['visible']) {
                    \Arr::set($returnRow, $value['label'] ?? $value['key'], \Arr::get($row, $value['key']));
                }
            }
        }

        return $returnRow;
    }

    public function getOriginalKeys(int $dataFeedId): ?array
    {
        if ($row = $this->getOriginalFirstRow($dataFeedId)) {
            return $this->array_keys_recursive($row);
        }

        return [];
    }

    public function getReferences(int $dataFeedId): ?array
    {
        if ($dataFeed = $this->getDataFeed($dataFeedId)) {
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
        }

        return [];
    }

    private function getDataFeed(int $dataFeedId): DataFeed|bool
    {
        return DataFeed::find($dataFeedId) ?? false;
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

    private function array_keys_recursive($myArray, $MAXDEPTH = INF, $depth = 0, $arrayKeys = [])
    {
        if ($depth < $MAXDEPTH) {
            $depth++;
            $keys = array_keys($myArray);
            foreach ($keys as $key) {
                if (is_array($myArray[$key])) {
                    $arrayKeys[$key] = $this->array_keys_recursive($myArray[$key], $MAXDEPTH, $depth);
                } else {
                    $arrayKeys[$key] = $key;
                }
            }
        }

        return $arrayKeys;
    }
}
