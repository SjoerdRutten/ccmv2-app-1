<?php

namespace Sellvation\CCMV2\Ems\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Ems\Models\EmailDkim;
use Spatie\Dns\Dns;

class CheckDkimJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly EmailDkim $emailDkim) {}

    public function handle(): void
    {
        $this->emailDkim->status = 0;
        $this->emailDkim->status_timestamp = now();

        $dns = new Dns;
        try {
            $records = $dns->getRecords($this->emailDkim->dnsRecordKey.'.'.$this->emailDkim->emailDomain->domain, 'TXT');
        } catch (\Exception $e) {
            $this->emailDkim->status_message = 'Kon records niet ophalen';

            return;
        }

        if (count($records)) {
            foreach ($records as $record) {
                if ($record->txt() === $this->emailDkim->dnsRecordValue) {
                    $this->emailDkim->status = 1;
                    $this->emailDkim->status_message = null;

                }
            }
        } else {
            $this->emailDkim->status_message = 'Geen geldig record gevonden';
        }

        $this->emailDkim->saveQuietly();
    }
}
