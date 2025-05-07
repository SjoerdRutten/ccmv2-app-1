<?php

namespace Sellvation\CCMV2\Ccm\Commands;

use Illuminate\Console\Command;
use Sellvation\CCMV2\Ccm\Models\Server;

class UpdateServerStatussesCommand extends Command
{
    protected $signature = 'ccmv2:update-server-statusses';

    protected $description = 'Update server statusses';

    public function handle(): void
    {
        foreach (Server::get() as $server) {
            $response = \Http::get($server->status_url);
            if ($response->ok()) {
                $data = $response->json();

                $server->statusses()->create([
                    'cpu_count' => \Arr::get($data, 'cpu_count', 0),
                    'disk_total_space' => \Arr::get($data, 'disk.total'),
                    'disk_free_space' => \Arr::get($data, 'disk.free'),
                    'ram_total_space' => \Arr::get($data, 'ram.total'),
                    'ram_free_space' => \Arr::get($data, 'ram.free'),
                    'load' => \Arr::get($data, 'load.0'),
                ]);
            }
        }
    }
}
