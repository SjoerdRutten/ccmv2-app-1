<?php

namespace Sellvation\CCMV2\CrmCards\Imports;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class CrmCardChunkedImport implements ToModel, WithChunkReading, WithHeadingRow
{
    private $action = null;

    public function __construct(private readonly \Sellvation\CCMV2\CrmCards\Models\CrmCardImport $import) {}

    public function chunkSize(): int
    {
        return 100;
    }

    public function model(array $row)
    {
        $this->action = 'error';

        $crmCard = $this->getCrmCard($row);
        $data = $this->getCrmCardData($crmCard->data ?? [], $row);

        if ($this->action === 'update') {
            $this->import->quantity_updated_rows = $this->import->quantity_updated_rows + 1;

            $updatedRows = $this->import->updated_rows ?? [];
            $updatedRows[] = $row;
            $this->import->updated_rows = $updatedRows;
        } elseif ($this->action === 'create') {
            $this->import->quantity_created_rows = $this->import->quantity_created_rows + 1;

            $createdRows = $this->import->created_rows ?? [];
            $createdRows[] = $row;
            $this->import->created_rows = $createdRows;
        } elseif ($this->action === 'empty') {
            $this->import->quantity_empty_rows = $this->import->quantity_empty_rows + 1;

            $emptyRows = $this->import->empty_rows ?? [];
            $emptyRows[] = $row;
            $this->import->empty_rows = $emptyRows;
        }

        $crmCard->data = $data;

        return $crmCard;
    }

    private function getCrmCardData(array $currenData, array $newData): array
    {
        $dataFields = \Arr::where($this->import->fields, function ($value, $key) {
            return \Arr::get($value, 'crm_field_id', 0) !== 0;
        });

        $allEmpty = true;
        foreach ($dataFields as $field) {
            $newValue = $newData[$field['key']];

            if (! empty($newValue)) {
                $allEmpty = false;
            }

            if ($crmField = CrmField::find($field['crm_field_id'])) {
                if (
                    (! empty($newValue) || $field['overwrite_empty']) &&
                    (empty($currenData[$crmField->name]) || $field['overwrite_filled'])
                ) {
                    $currenData[$crmField->name] = $newValue;
                }
            }
        }

        if ($allEmpty) {
            $this->action = 'empty';
        }

        return $currenData;
    }

    private function getCrmCard(array $rowData): CrmCard
    {
        $attachedFields = \Arr::where($this->import->fields, function ($value, $key) {
            return \Arr::get($value, 'attach_to_crm_card', false);
        });

        $crmCard = null;

        if (count($attachedFields) > 0) {
            foreach ($attachedFields as $field) {
                if (! $crmCard) {
                    if ($field['crm_field_id'] === 'crm_id') {
                        $crmCard = CrmCard::where('crm_id', $rowData[$field['key']])->first();
                    } elseif (! Str::contains($field['crm_field_id'], '_')) {
                        $crmField = CrmField::find($field['crm_field_id']);

                        if ($mongoCrmCard = CrmCardMongo::where($crmField->name, $rowData[$field['key']])->first()) {
                            $crmCard = CrmCard::find($mongoCrmCard->id);
                        }
                    }
                }
            }
        }

        // Update total number of rows
        $this->import->number_of_rows = $this->import->number_of_rows + 1;

        if ($crmCard !== null) {
            $this->action = 'update';

            return $crmCard;
        }

        $this->action = 'create';

        return new CrmCard;
    }
}
