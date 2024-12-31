<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Imports;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Imports\CrmCardLimitArrayImport;
use Sellvation\CCMV2\CrmCards\Models\CrmCardImport;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public ?TemporaryUploadedFile $file = null;

    public array $rows = [];

    public array $sheet = [];

    public bool $showAll = false;

    public function updated($property, $value)
    {
        switch ($property) {
            case 'file':
                $this->readFile();
                break;
        }
    }

    public function readFile()
    {
        if ($this->file) {
            $sheets = (new CrmCardLimitArrayImport)->toArray($this->file->getRealPath());
            $this->sheet = \Arr::first($sheets);

            $this->rows = [];
            foreach (array_keys(\Arr::first($this->sheet)) as $key) {
                $this->addRow($key);
            }
        }
    }

    public function startImport()
    {
        CrmCardImport::create([
            'path' => \Storage::path($this->file->store()),
            'file_name' => $this->file->getClientOriginalName(),
            'fields' => $this->rows,
        ]);

        $this->showSuccessModal('Import in de wachtrij geplaatst', route('crm-cards::imports::overview'));
    }

    private function addRow($key)
    {
        $crmField = CrmField::where('name', 'like', $key)->first();

        $this->rows[] = [
            'key' => $key,
            'crm_field_id' => (int) $crmField?->id,
            'attach_to_crm_card' => false,
            'overwrite_empty' => false,
            'overwrite_filled' => false,
        ];
    }

    public function render()
    {
        return view('crm-cards::livewire.imports.edit')
            ->with([
                'crmFields' => CrmField::orderBy('name')->get(),
            ]);
    }
}
