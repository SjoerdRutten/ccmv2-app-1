<?php

namespace Sellvation\CCMV2\Sites\Livewire\Layouts\Forms;

use Illuminate\Support\Arr;
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

    public ?array $config = [];

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
            'config' => [
                'nullable',
                'array',
            ],
        ];
    }

    public function setSiteLayout(SiteLayout $siteLayout)
    {
        $this->siteLayout = $siteLayout;
        $this->fill($siteLayout->toArray());
    }

    public function addBlock()
    {
        $block = [
            'key' => uniqid(),
            'description' => 'Omschrijving van het blok',
            'multiple' => false,
        ];

        //        $this->config = $this->config ?: [];
        $this->config = Arr::add($this->config, uniqid(), $block);
    }

    public function save(): SiteLayout
    {
        $this->validate();

        $data = $this->except('siteLayout', 'id');

        $data['index'] = (bool) $data['index'];
        $data['follow'] = (bool) $data['follow'];

        if ($this->siteLayout->id) {
            $this->siteLayout->update($data);
        } else {
            $this->siteLayout = SiteLayout::create($data);
        }

        $this->setSiteLayout($this->siteLayout);

        return $this->siteLayout;
    }
}
