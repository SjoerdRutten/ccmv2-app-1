<?php

namespace Sellvation\CCMV2\MailServers\Commands;

use Illuminate\Console\Command;
use Sellvation\CCMV2\MailServers\Jobs\CheckMailserverJob;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class CheckMailServersCommand extends Command
{
    protected $signature = 'mailservers:check';

    protected $description = 'Check mailservers';

    public function handle(): void
    {
        foreach (Mailserver::where('is_active', 1)->get() as $mailserver) {
            $this->output->info($mailserver->private_ip);
            CheckMailserverJob::dispatchSync($mailserver);
        }
    }
}
