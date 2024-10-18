<?php

namespace Sellvation\CCMV2\Typesense\Facades;

use Symfony\Component\HttpClient\HttplugClient;
use Typesense\Client;

class Typesense
{
    private function getClient()
    {
        return new Client(
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

    public function getMetrics()
    {
        $client = $this->getClient();

        return $client->getMetrics()->retrieve();
    }
}
