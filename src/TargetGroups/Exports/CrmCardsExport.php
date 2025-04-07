<?php

namespace Sellvation\CCMV2\TargetGroups\Exports;

use Carbon\Carbon;
use Generator;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupExport;

class CrmCardsExport implements FromGenerator, ShouldAutoSize, WithHeadings, WithMapping
{
    private array $fields = [];

    private \DateTime $startedAt;

    public function __construct(private readonly TargetGroupExport $targetGroupExport)
    {
        $this->fields = Arr::sort($this->targetGroupExport->targetGroupFieldset->crmFields->pluck('name')->toArray());
        $this->startedAt = Carbon::parse($this->targetGroupExport->started_at);
    }

    public function generator(): Generator
    {
        $progress = 0;

        $query = TargetGroupSelectorFacade::getQuery($this->targetGroupExport->targetGroup->filters);

        foreach ($query->lazyById(500) as $crmCard) {
            $progress++;

            // Elke 1000 records: update progress en expected_end_time
            if ($progress % 1000 === 0 || $progress === $this->targetGroupExport->number_of_records) {
                $secondsSinceStart = $this->startedAt->diffInMicroseconds(now());
                $secondsPerRecord = $secondsSinceStart / $progress;

                $expectedEndTime = now()->addMicroseconds(
                    ceil($secondsPerRecord * ($this->targetGroupExport->number_of_records - $progress))
                );

                $this->targetGroupExport->update([
                    'progress' => $progress,
                    'expected_end_time' => $expectedEndTime,
                ]);
            }

            yield $crmCard;
        }

        // Final update
        $this->targetGroupExport->update([
            'progress' => $progress,
        ]);
    }

    public function headings(): array
    {
        return array_merge(
            [
                'crm_id',
            ],
            $this->fields,
        );
    }

    public function map(mixed $row): array
    {
        $data = [
            $row->crm_id,
        ];

        if ($row->data) {
            return array_merge($data, Arr::only($row->data, $this->fields));
        }

        return $data;
    }
}
