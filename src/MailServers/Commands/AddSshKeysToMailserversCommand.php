<?php

namespace Sellvation\CCMV2\MailServers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class AddSshKeysToMailserversCommand extends Command
{
    protected $signature = 'mailservers:add-keys';

    protected $description = 'Add SSH keys to mailservers';

    public function handle(): void
    {
        $publicKeyFileName = uniqid().'.pub';

        Storage::put($publicKeyFileName, trim(config('ccm.ssh_public_key')));

        $path = Storage::path($publicKeyFileName);
        chmod($path, 0600);

        foreach (MailServer::all() as $mailserver) {
            system('ssh-copy-id -f -i '.$path.' '.config('ccm.ssh_user').'@'.$mailserver->private_ip);
        }

        Storage::delete($publicKeyFileName);
    }
}
