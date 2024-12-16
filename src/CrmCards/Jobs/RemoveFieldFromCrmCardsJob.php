<?php

namespace Sellvation\CCMV2\CrmCards\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\CrmCards\Models\Builders\CrmFieldType;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class RemoveFieldFromCrmCardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private string $name, private readonly CrmFieldType $crmFieldType, private int $start, private int $limit)
    {
        $this->queue = 'scout';
    }

    public function handle(): void
    {
        foreach (CrmCard::skip($this->start)->limit($this->limit)->get() as $crmCard) {
            $data = $crmCard->data;
            \Arr::pull($data, $this->name);
            $crmCard->data = $data;
            $crmCard->save();
        }
    }
}
