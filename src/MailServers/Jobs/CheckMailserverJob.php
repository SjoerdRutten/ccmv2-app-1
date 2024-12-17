<?php

namespace Sellvation\CCMV2\MailServers\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Sellvation\CCMV2\MailServers\Models\MailServer;
use Spatie\Ssh\Ssh;

class CheckMailserverJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly MailServer $mailServer) {}

    public function handle(): void
    {
        $privateKeyFileName = $this->createPrivateKey();
        $process = $this->getSshProcess($privateKeyFileName);

        if ($this->checkMailServerValid($process)) {
            $this->mailServer->mailServerStats()->create([
                'load' => (float) $this->execute($process, 'uptime | awk {\'print $11\'}'),
                'memory_total' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'free | head -n 2 | tail -n 1 | awk {\'print $2\'}']),
                'memory_used' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'free | head -n 2 | tail -n 1 | awk {\'print $3\'}']),
                'memory_free' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'free | head -n 2 | tail -n 1 | awk {\'print $4\'}']),
                'queue_size' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'qshape active | head -n 2 | tail -n 1 | awk {\'print $2\'}']),
                'deferred_queue_size' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'qshape deferred | head -n 2 | tail -n 1 | awk {\'print $2\'}']),
            ]);
        }

        Storage::delete($privateKeyFileName);
    }

    private function execute($process, $commands)
    {
        try {
            return $process->execute($commands)->getOutput();
        } catch (\Exception $exception) {
            $this->mailServer->update(['is_valid' => false]);
            exit();
        }
    }

    private function checkMailServerValid($process): bool
    {
        if (\Str::startsWith($this->execute($process, 'systemctl is-active postfix'), 'active')) {
            $this->mailServer->update(['is_valid' => true]);

            return true;
        }

        $this->mailServer->update(['is_valid' => false]);

        return false;
    }

    private function createPrivateKey()
    {
        $privateKeyFileName = uniqid();

        Storage::put($privateKeyFileName, trim(config('ccm.ssh_private_key')).PHP_EOL);
        chmod(Storage::path($privateKeyFileName), 0600);

        return $privateKeyFileName;
    }

    private function getSshProcess($privateKeyFileName)
    {
        return Ssh::create('ccmv2', $this->mailServer->private_ip)
            ->setTimeout(5)
            ->usePrivateKey(Storage::path($privateKeyFileName))
            ->useMultiplexing(Storage::path('/mx01', '5m'));
    }
}
