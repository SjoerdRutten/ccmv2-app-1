<?php

namespace Sellvation\CCMV2\Sites\Livewire\Blocks\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Sites\Models\SiteBlock;

class BlockForm extends Form
{
    #[Locked]
    public SiteBlock $siteBlock;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public $name;

    #[Validate]
    public $description;

    public $form_id;

    public $start_at;

    public $end_at;

    public $body;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'form_id' => [
                'nullable',
                'exists:forms,id',
            ],
            'start_at' => [
                'nullable',
                'date',
            ],
            'end_at' => [
                'nullable',
                'date',
            ],
            'body' => [
                'nullable',
            ],
        ];
    }

    public function setSiteBlock(SiteBlock $siteBlock)
    {
        $this->siteBlock = $siteBlock;

        $this->fill($siteBlock->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->except('siteBlock', 'id');

        if ($this->siteBlock->id) {
            $this->siteBlock->update($data);
        } else {
            $this->siteBlock = SiteBlock::create($data);
        }

        $this->setSiteBlock($this->siteBlock);

        return $this->siteBlock;
    }
}
