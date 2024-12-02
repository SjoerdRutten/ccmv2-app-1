<?php

namespace Sellvation\CCMV2\Sites\Livewire\Pages\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Sites\Models\SitePage;

class PageForm extends Form
{
    use WithFileUploads;

    public SitePage $sitePage;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public ?int $site_layout_id = null;

    #[Validate]
    public ?int $site_id = null;

    #[Validate]
    public $name;

    #[Validate]
    public $slug;

    #[Validate]
    public $start_at;

    #[Validate]
    public $end_at;

    public bool $slugGenerated = true;

    #[Validate]
    public $description;

    public $config = [];

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'site_layout_id' => [
                'required',
                'exists:site_layouts,id',
            ],
            'site_id' => [
                'nullable',
                'exists:sites,id',
            ],
            'name' => [
                'required',
            ],
            'slug' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'start_at' => [
                'nullable',
                'date',
            ],
            'end_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    public function setSitePage(SitePage $sitePage)
    {
        $this->sitePage = $sitePage;

        $this->fill($sitePage->toArray());
        $this->setSitePageConfig($sitePage->siteLayout);
    }

    public function setSitePageConfig($siteLayout)
    {
        $this->config = [];

        if ($siteLayout) {
            foreach ($siteLayout->config as $row) {
                if ($row['multiple']) {
                    $this->config[$row['key']] = array_values(\Arr::get($this->sitePage->config, $row['key'], []));
                } else {
                    $this->config[$row['key']] = \Arr::get($this->sitePage->config, $row['key']);
                }
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = $this->except('sitePage', 'id', 'slugGenerated');

        if ($this->sitePage->id) {
            $this->sitePage->update($data);
        } else {
            $this->sitePage = SitePage::create($data);
        }

        $this->setSitePage($this->sitePage);

        return $this->sitePage;
    }
}
