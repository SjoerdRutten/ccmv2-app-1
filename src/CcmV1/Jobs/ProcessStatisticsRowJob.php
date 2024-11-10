<?php

namespace Sellvation\CCMV2\CcmV1\Jobs;

use Base62\Facades\Base62;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\EmailStatistic;

class ProcessStatisticsRowJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly int $environmentId, private $row) {}

    public function handle(): void
    {
        Config::set('database.connections.db02.database', 'ccmp');

        if ($crmCard = \DB::connection('db02')
            ->table('crm_'.$this->environmentId)
            ->select(['crmid'])
            ->where('id', $this->row->crm_id)
            ->first()) {
            if ($crmCard = CrmCard::select(['id'])->where('crm_id', $crmCard->crmid)->first()) {
                EmailStatistic::whereCrmCardId($crmCard->id)->delete();

                $this->processField($this->row->email_verzonden, 'send', $crmCard->id);
                $this->processField($this->row->email_gebounced, 'bounced', $crmCard->id);
                $this->processField($this->row->email_geopend, 'opened', $crmCard->id);
                $this->processField($this->row->email_geklikt, 'clicked', $crmCard->id);
            }
        }
    }

    private function processField($fieldValue, $column, $crmCardId)
    {
        $items = explode(':', $fieldValue);

        foreach ($items as $item) {
            if (! empty($item)) {
                $emailId = Base62::decode($item);

                try {
                    EmailStatistic::query()
                        ->updateOrInsert([
                            'crm_card_id' => $crmCardId,
                            'email_id' => $emailId,
                        ], [
                            $column => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                } catch (\Exception $e) {
                    // Email ID doesn't exists anymore
                }
            }
        }
    }
}
