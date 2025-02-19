<?php

namespace Sellvation\CCMV2\DataFeeds\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\DataFeeds\Models\DataFeed;
use Sellvation\CCMV2\DataFeeds\Models\DataFeedFetch;

class FetchDataFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private DataFeedFetch $dataFeedFetch;

    public function __construct(private readonly DataFeed $dataFeed) {}

    public function handle(): void
    {
        $this->dataFeedFetch = new DataFeedFetch;
        $this->dataFeedFetch->dataFeed()->associate($this->dataFeed);
        $this->dataFeedFetch->started_at = now();

        $this->{$this->dataFeed->type}();

        $this->dataFeedFetch->ended_at = now();
        $this->dataFeedFetch->save();
    }

    private function https(): void
    {
        $feedConfig = $this->dataFeed->feed_config;

        $request = \Http::createPendingRequest();

        if (\Arr::get($feedConfig, 'username') && \Arr::get($feedConfig, 'password')) {
            $request->withBasicAuth(\Arr::get($feedConfig, 'username'), \Arr::get($feedConfig, 'password'));
        }

        $response = $request->get(\Arr::get($feedConfig, 'url'));

        $this->dataFeedFetch->status = $response->getStatusCode();

        if ($response->successful()) {
            $this->dataFeedFetch->file_name = 'datafeed/'.uniqid('DF_');
            $this->dataFeedFetch->disk = 'local';

            \Storage::disk($this->dataFeedFetch->disk)->put($this->dataFeedFetch->file_name, $response->getBody());
        }
    }
}
