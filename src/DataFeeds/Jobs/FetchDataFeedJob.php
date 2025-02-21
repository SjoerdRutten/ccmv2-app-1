<?php

namespace Sellvation\CCMV2\DataFeeds\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
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

    private function ftps(): void
    {
        $feedConfig = $this->dataFeed->feed_config;

        $adapter = new FtpAdapter(FtpConnectionOptions::fromArray([
            'host' => $feedConfig['host'],
            'root' => '/',
            'username' => $feedConfig['username'],
            'password' => $feedConfig['password'],
            'port' => (int) $feedConfig['port'],
            'ssl' => $feedConfig['encryption'] ? true : false,
            'timeout' => 90,
            'utf8' => false,
            'transferMode' => FTP_ASCII,
            'systemType' => null,
            'ignorePassiveAddress' => null,
            'timestampsOnUnixListingsEnabled' => false,
            'recurseManually' => true,
        ]));

        if ($filesystem = new Filesystem($adapter)) {
            $this->dataFeedFetch->file_name = 'datafeed/'.uniqid('DF_');
            $this->dataFeedFetch->disk = 'local';
            $this->dataFeedFetch->status = 200;

            \Storage::disk($this->dataFeedFetch->disk)->put($this->dataFeedFetch->file_name, $filesystem->read($feedConfig['path']));
        }
    }

    private function sql(): void
    {
        $feedConfig = $this->dataFeed->feed_config;

        $response = DB::select($feedConfig['query']);

        $this->dataFeedFetch->file_name = 'datafeed/'.uniqid('DF_');
        $this->dataFeedFetch->disk = 'local';
        $this->dataFeedFetch->status = 200;

        \Storage::disk($this->dataFeedFetch->disk)->put($this->dataFeedFetch->file_name, json_encode($response));
    }
}
