<?php

namespace Sellvation\CCMV2\Ems\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;
use Sellvation\CCMV2\Ems\Models\EmailDkim;

class GenerateDkimJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly EmailDkim $emailDkim) {}

    public function handle(): void
    {
        $fileName = uniqid();
        $fileNamePriv = $fileName.'.priv';
        $fileNamePub = $fileName.'.pub';

        Process::run('openssl genrsa -out '.\Storage::path($fileNamePriv).' 4096');
        $this->emailDkim->private_key = \Storage::get($fileNamePriv);

        Process::run('openssl rsa -in '.\Storage::path($fileNamePriv).' -pubout -out '.\Storage::path($fileNamePub));
        $this->emailDkim->public_key = \Storage::get($fileNamePub);
        $this->emailDkim->expires_at = now()->addYear();
        $this->emailDkim->saveQuietly();

        \Storage::delete($fileNamePriv);
        \Storage::delete($fileNamePub);
    }
}
