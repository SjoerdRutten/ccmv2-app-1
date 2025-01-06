<?php

namespace Sellvation\CCMV2\MailServers\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Sellvation\CCMV2\MailServers\Models\MailServer;
use Sellvation\CCMV2\MailServers\Traits\MailserverSsh;

class CheckMailserverJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use MailserverSsh;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly MailServer $mailServer) {}

    public function handle(): void
    {
        $privateKeyFileName = $this->createPrivateKey();
        $process = $this->getSshProcess($this->mailServer, $privateKeyFileName);

        if ($this->checkMailServerValid($process)) {
            try {
                $this->mailServer->mailServerStats()->create([
                    'load' => (float) $this->execute($process, 'uptime | awk {\'print $11\'}'),
                    'memory_total' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'free | head -n 2 | tail -n 1 | awk {\'print $2\'}']),
                    'memory_used' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'free | head -n 2 | tail -n 1 | awk {\'print $3\'}']),
                    'memory_free' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'free | head -n 2 | tail -n 1 | awk {\'print $4\'}']),
                    'queue_size' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'qshape active | head -n 2 | tail -n 1 | awk {\'print $2\'}']),
                    'deferred_queue_size' => $this->execute($process, ['export PATH=$PATH:/usr/sbin', 'qshape deferred | head -n 2 | tail -n 1 | awk {\'print $2\'}']),
                ]);
            } catch (\Exception $exception) {
                $this->mailServer->update(['is_valid' => false]);
            }

            $this->mailServer->update(['is_valid' => true]);
        }

        Storage::delete($privateKeyFileName);
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
}
