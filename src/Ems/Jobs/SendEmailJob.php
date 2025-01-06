<?php

namespace Sellvation\CCMV2\Ems\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Sellvation\CCMV2\Ems\Mailables\CcmMail;
use Sellvation\CCMV2\MailServers\Models\MailServer;
use Sellvation\CCMV2\MailServers\Traits\MailserverSsh;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use MailserverSsh;
    use Queueable;
    use SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        /*
        $mail = Mail::mailer('array')
            ->to('sjoerd@sellvation.nl')
            ->send(new CcmMail);

        $command = [
            'export PATH=$PATH:/usr/sbin',
            'sendmail -t < /home/ccmv2/test',
        ];

        $privateKeyFileName = $this->createPrivateKey();
        $process = $this->getSshProcess($this->selectMailer(), $privateKeyFileName);

        try {
            dd($process->execute($command)->getOutput());
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        */
    }

    private function selectMailer(): MailServer
    {
        return MailServer::find(4);
    }
}
