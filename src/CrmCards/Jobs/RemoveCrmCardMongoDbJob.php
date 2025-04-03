<?php

namespace Sellvation\CCMV2\CrmCards\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;

class RemoveCrmCardMongoDbJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly CrmCard $crmCard)
    {
        $this->queue = '{scout}';
    }

    public function handle(): void
    {
        $environmentId = $this->ask('Welke environment ?');
        \Context::add('environment_id', $environmentId);

        if ($crmCardMongo = CrmCardMongo::where('id', $this->crmCard->id)->first()) {
            $crmCardMongo->delete();
        }
    }
}
