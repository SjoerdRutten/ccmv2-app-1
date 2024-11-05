<?php

namespace Sellvation\CCMV2\Typesense\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpClient\HttplugClient;
use Typesense\Client;

class TypesenseJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Client $client;

    protected function initClient()
    {
        $this->client = new Client(
            [
                'api_key' => config('scout.typesense.client-settings.api_key'),
                'nodes' => [
                    [
                        'host' => 'localhost',
                        'port' => '8108',
                        'protocol' => 'http',
                    ],
                ],
                'client' => new HttplugClient,
            ]
        );
    }

    public function handle(): void {}
}
