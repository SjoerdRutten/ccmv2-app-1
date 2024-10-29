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

    public function getCollections()
    {
        $client = $this->getClient();

        return $client->getCollections()->retrieve();
    }

    public function getCollection(string $collectionName)
    {
        $client = $this->getClient();

        return $client->collections[$collectionName]->retrieve();
    }

    public function updateCollectionSchema(string $collectionName, array $schema)
    {
        $client = $this->getClient();

        return $client->collections[$collectionName]->update($schema);
    }

    public function removeCollection(string $collectionName)
    {
        $client = $this->getClient();

        return $client->collections[$collectionName]->delete();
    }
}
