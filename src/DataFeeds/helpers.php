<?php

declare(strict_types=1);

if (! function_exists('datafeed')) {
    function datafeed(int $dataFeedId, ?string $reference, string $field): mixed
    {
        return \DataFeedConnector::getValue($dataFeedId, $reference, $field);
    }
}

if (! function_exists('dataFeed')) {
    function dataFeed(int $dataFeedId, ?string $reference, string $field): mixed
    {
        return \DataFeedConnector::getValue($dataFeedId, $reference, $field);
    }
}
