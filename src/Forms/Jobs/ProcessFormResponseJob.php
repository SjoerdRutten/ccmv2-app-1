<?php

namespace Sellvation\CCMV2\Forms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Forms\Models\FormResponse;

class ProcessFormResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly FormResponse $formResponse) {}

    public function handle(): void
    {
        /** @var CrmCard $crmCard */
        $crmCard = $this->formResponse->crmCard;

        $changed = $crmCard->setData($this->formResponse->data);

        if (count(\Arr::get($changed, 'success'))) {
            $crmCard->save();
        }

        // TODO: Acties uitvoeren
    }
}
