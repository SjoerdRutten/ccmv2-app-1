<?php

namespace Sellvation\CCMV2\TargetGroups\Exports;

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
    public function __construct(private readonly TargetGroupExport $targetGroupExport) {}

    public function generator(): Generator
    {
        $page = 0;
        do {
            $crmCards = TargetGroupSelectorFacade::getQuery($this->targetGroupExport->targetGroup->filters, 100, $page)->get();

            foreach ($crmCards as $crmCard) {
                yield $crmCard;
            }

            $progress = ($page * 100) + count($crmCards);
            $progress = $progress > $this->targetGroupExport->number_of_records ? $this->targetGroupExport->number_of_records : $progress;

            $this->targetGroupExport->update(['progress' => $progress]);
            $page++;

        } while (count($crmCards) > 0);
    }

    public function headings(): array
    {
        $headings = array_merge(
            [
                'crm_id',
            ],
            $this->targetGroupExport->targetGroupFieldset->crmFields()->pluck('name')->toArray()
        );

        return $this->targetGroupExport->targetGroupFieldset->crmFields()->pluck('name')->toArray();
    }

    public function map(mixed $row): array
    {
        $data = [
            $row->crm_id,
        ];

        foreach ($this->targetGroupExport->targetGroupFieldset->crmFields as $crmField) {
            $data[] = Arr::get($row->data, $crmField->name);
        }

        return $data;

    }
}
