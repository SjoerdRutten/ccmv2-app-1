<?php

namespace Sellvation\CCMV2\CcmV1\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddTagToCrmCardJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly string $crmId,
        private readonly string $tag,
        private readonly string $fieldName = 'algemeen_veld_5',
        private readonly string $seperator = ',') {}

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $environmentId = 105; //\Context::get('environment_id');

        if ($row = \DB::connection('db01')
            ->table('crm_'.$environmentId)
            ->select([
                'id',
                'crmid',
                $this->fieldName,
            ])
            ->where('crmid', $this->crmId)
            ->first()) {

            //            $tags = explode($this->seperator, $row->{$this->fieldName});
            //            $tags[] = $this->tag;

            //            \DB::connection('db01')
            //                ->table('crm_'.$environmentId)
            //                ->where('id', $row->id)
            //                ->update([$this->fieldName => implode($this->seperator, $tags)]);
        }
    }
}
