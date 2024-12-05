<?php

namespace Sellvation\CCMV2\Sites\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Sites\Models\SitePageVisit;

class AddCrmIdToSitePageVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly SitePageVisit $sitePageVisit) {}

    public function handle(): void
    {
        if ($this->sitePageVisit->crm_id) {
            $crmCard = CrmCard::where('crm_id', $this->sitePageVisit->crm_id)->first(['id']);

            $this->sitePageVisit->crm_card_id = $crmCard->id;
            $this->sitePageVisit->save();
        }
    }
}
