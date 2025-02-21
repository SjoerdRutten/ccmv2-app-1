<?php

namespace Sellvation\CCMV2\DataFeeds\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Sellvation\CCMV2\DataFeeds\Models\DataFeed;
use Sellvation\CCMV2\DataFeeds\Models\DataFeedFetch;

class ParseDataFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private DataFeed $dataFeed;

    public function __construct(private readonly DataFeedFetch $dataFeedFetch) {}

    public function handle(): void
    {
        $this->dataFeed = $this->dataFeedFetch->dataFeed;
        $feedConfig = $this->dataFeed->feed_config;

        $function = 'parse'.ucfirst($feedConfig['content_type']);
        $this->dataFeed->data = $this->mapData($this->{$function}($feedConfig));
        $this->dataFeed->save();
    }

    private function parseJson(array $feedConfig)
    {
        return json_decode(
            Storage::disk($this->dataFeedFetch->disk)->get($this->dataFeedFetch->file_name),
            true
        );
    }

    private function parseCsv(array $feedConfig)
    {
        //        "escape" => "\"
        //  "enclosure" => "double_quotes"
        //  "seperator" => "semicolon"
        //  "header_row" => "1"

        $handle = fopen(Storage::disk($this->dataFeedFetch->disk)->path($this->dataFeedFetch->file_name), 'r');

        $columnNames = [];
        $data = [];
        $index = 0;
        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            if (($feedConfig['header_row']) && ($index === 0)) {
                foreach ($row as $columnName) {
                    if (! empty(trim($columnName))) {
                        $columnNames[] = trim($columnName);
                    }
                }
            }

            if ((! $feedConfig['header_row']) || ($index > 0)) {
                foreach ($row as $key => $value) {
                    $data[$index][\Arr::get($columnNames, $key, $key)] = $value;
                }
            }

            $index++;
        }

        fclose($handle);

        return array_values($data);
    }

    private function parseXml(array $feedConfig)
    {
        $xml = json_decode(json_encode(simplexml_load_string(Storage::disk($this->dataFeedFetch->disk)->get($this->dataFeedFetch->file_name))), true);

        return \Arr::first($xml);
    }

    private function mapData(array $data): array
    {
        return $data;
    }
}
