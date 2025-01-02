<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Imports;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Imports\CrmCardLimitWithHeadingArrayImport;
use Sellvation\CCMV2\CrmCards\Imports\CrmCardLimitWithoutHeadingArrayImport;
use Sellvation\CCMV2\CrmCards\Models\CrmCardImport;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public ?TemporaryUploadedFile $file = null;

    public ?string $fileType = null;

    public array $rows = [];

    public array $sheet = [];

    public bool $showAll = false;

    public array $config = [
        'has_header' => 1,
        'delimiter' => ';',
        'enclosure' => 'dq',
        'escape_character' => '\\',
    ];

    public function updated($property, $value)
    {
        if (Str::startsWith($property, 'config.')) {
            $this->readFile();
        } else {
            switch ($property) {
                case 'file':
                    $this->readFile();
                    break;
            }
        }
    }

    public function readFile()
    {
        if ($this->file && $this->file->isValid()) {
            if (\Str::contains($this->file->getMimeType(), 'text/csv')) {
                $this->fileType = 'csv';
            } elseif (\Str::contains($this->file->getMimeType(), [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel',
            ])) {
                $this->fileType = 'excel';
            } else {
                $this->fileType = 'error';
            }

            if ($this->config['has_header']) {
                $import = new CrmCardLimitWithHeadingArrayImport($this->config);
            } else {
                $import = new CrmCardLimitWithoutHeadingArrayImport($this->config);
            }

            if ($this->fileType !== 'error') {
                $sheets = $import->toArray($this->file->getRealPath());
                $this->sheet = \Arr::first($sheets);

                $this->rows = [];
                foreach (array_keys(\Arr::first($this->sheet)) as $key) {
                    $this->addRow($key);
                }
            }
        }
    }

    public function startImport()
    {
        CrmCardImport::create([
            'path' => \Storage::path($this->file->store()),
            'file_name' => $this->file->getClientOriginalName(),
            'config' => $this->config,
            'fields' => $this->rows,
        ]);

        $this->showSuccessModal(title: 'Import in de wachtrij geplaatst',
            message: 'De import zal op de achtergrond worden gestart, in het overzicht kan je zien of de import gereed is',
            href: route('crm-cards::imports::overview'));
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
