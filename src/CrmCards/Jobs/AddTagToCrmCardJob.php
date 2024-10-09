<?php

namespace Sellvation\CCMV2\CrmCards\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Spatie\Tags\Tag;

class AddTagToCrmCardJob
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly CrmCard $crmCard,
        private readonly string $tag,
        private readonly string $fieldName = 'algemeen_veld_5',
        private readonly string $seperator = ',') {}

    public function handle(): void
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        $this->addToVersion1();
        $this->addToVersion2();
    }

    private function addToVersion2(): void
    {
        $type = 'crm-card-'.\Context::get('environment_id');

        $tag = Tag::findOrCreateFromString($this->tag, $type);

        $this->crmCard->syncTagsWithType([$tag], $type);
        $this->crmCard->touch();
    }

    private function addToVersion1(): void
    {
        $environmentId = \Context::get('environment_id');

        if ($row = \DB::connection('db01')
            ->table('crm_'.$environmentId)
            ->select([
                'id',
                'crmid',
                $this->fieldName,
            ])
            ->where('crmid', $this->crmCard->crm_id)
            ->first()) {

            $tags = explode($this->seperator, $row->{$this->fieldName});
            $tags[] = $this->tag;

            $tags = array_unique($tags);

            $tags = \Arr::where($tags, fn ($value) => filled($value));

            \DB::connection('db01')
                ->table('crm_'.$environmentId)
                ->where('id', $row->id)
                ->update([$this->fieldName => implode($this->seperator, $tags)]);
        }
    }
}
