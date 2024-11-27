<?php

namespace Sellvation\CCMV2\Sites\Livewire\Layouts\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Sites\Models\SiteLayout;

class LayoutForm extends Form
{
    #[Locked]
    public SiteLayout $siteLayout;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public $name;

    #[Validate]
    public $description;

    #[Validate]
    public $meta_title;

    #[Validate]
    public $meta_description;

    #[Validate]
    public $meta_keywords;

    #[Validate]
    public $follow;

    #[Validate]
    public $index;

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
            'meta_title' => [
                'nullable',
                'string',
            ],
            'meta_description' => [
                'nullable',
                'string',
            ],
            'meta_keywords' => [
                'nullable',
                'string',
            ],
            'follow' => [
                'nullable',
                'bool',
            ],
            'index' => [
                'nullable',
                'bool',
            ],
        ];
    }

    public function setSiteLayout(SiteLayout $siteLayout)
    {
        $this->siteLayout = $siteLayout;

        $this->fill($siteLayout->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->except('siteLayout', 'id');

        if ($this->siteLayout->id) {
            $this->siteLayout->update($data);
        } else {
            $this->siteLayout = SiteLayout::create($data);
        }

        $this->setSiteLayout($this->siteLayout);

    }
}
