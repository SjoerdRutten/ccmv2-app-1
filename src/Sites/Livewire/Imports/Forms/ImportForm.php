<?php

namespace Sellvation\CCMV2\Sites\Livewire\Imports\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Sites\Models\SiteImport;

class ImportForm extends Form
{
    #[Locked]
    public SiteImport $siteImport;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public $type;

    #[Validate]
    public $name;

    #[Validate]
    public $description;

    public $body;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'type' => [
                'required',
                'in:js,css',
            ],
            'name' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
        ];
    }

    public function setSiteImport(SiteImport $siteImport)
    {
        $this->siteImport = $siteImport;

        $this->fill($siteImport->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->except('siteImport', 'id');

        if ($this->siteImport->id) {
            $this->siteImport->update($data);
        } else {
            $this->siteImport = SiteImport::create($data);
        }

        $this->setSiteImport($this->siteImport);

    }
}
