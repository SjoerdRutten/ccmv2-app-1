<?php

namespace Sellvation\CCMV2\Sites\Livewire\Scrapers\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Sites\Models\SiteScraper;

class ScraperForm extends Form
{
    public SiteScraper $siteScraper;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public $name;

    #[Validate]
    public $description;

    #[Validate]
    public $target;

    #[Validate]
    public $url;

    #[Validate]
    public $base_url;

    #[Validate]
    public $site_layout_id;

    #[Validate]
    public $layout_name;

    #[Validate]
    public $site_block_id;

    #[Validate]
    public $block_name;

    #[Validate]
    public $start_selector;

    public $current = true;

    public function rules(): array
    {
        $rules = [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'url' => [
                'required',
                'url',
            ],
            'base_url' => [
                'required',
                'url',
            ],
        ];

        if ($this->target === 'layout') {
            if ($this->current) {
                $rules['site_layout_id'] = [
                    'required',
                    'exists:site_layouts,id',
                ];
            } else {
                $rules['layout_name'] = [
                    'required',
                    'string',
                ];
            }
        } elseif ($this->target === 'block') {
            if ($this->current) {
                $rules['site_block_id'] = [
                    'required',
                    'exists:site_blocks,id',
                ];
            } else {
                $rules['block_name'] = [
                    'required',
                    'string',
                ];
            }
            $rules['start_selector'] = [
                'required',
                'string',
            ];
        }

        return $rules;
    }

    public function setSiteScraper(SiteScraper $siteScraper)
    {
        $this->siteScraper = $siteScraper;

        $this->fill($siteScraper->toArray());

        if ($siteScraper->layout_name || $siteScraper->block_name) {
            $this->current = false;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->current) {
            $this->block_name = null;
            $this->layout_name = null;
        } else {
            $this->site_block_id = null;
            $this->site_layout_id = null;
        }

        $data = $this->except('siteScraper', 'id', 'current');

        if ($this->siteScraper->id) {
            $this->siteScraper->update($data);
        } else {
            $data['status'] = 'new';
            $this->siteScraper = SiteScraper::create($data);
        }

        $this->setSiteScraper($this->siteScraper);

        return $this->siteScraper;
    }
}
