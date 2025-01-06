<?php

namespace Sellvation\CCMV2\MailServers\Traits;

use Illuminate\Support\Facades\Storage;
use Sellvation\CCMV2\MailServers\Models\MailServer;
use Spatie\Ssh\Ssh;

trait MailserverSsh
{
    private function createPrivateKey()
    {
        $privateKeyFileName = uniqid();

        Storage::put($privateKeyFileName, trim(config('ccm.ssh_private_key')).PHP_EOL);
        chmod(Storage::path($privateKeyFileName), 0600);

        return $privateKeyFileName;
    }

    private function getSshProcess(MailServer $mailServer, $privateKeyFileName)
    {
        return Ssh::create('ccmv2', $mailServer->private_ip)
            ->setTimeout(5)
            ->usePrivateKey(Storage::path($privateKeyFileName))
            ->useMultiplexing(Storage::path('/'.$mailServer->name, '5m'));
    }

    private function execute($process, $commands)
    {
        return $process->execute($commands)->getOutput();
    }
}
