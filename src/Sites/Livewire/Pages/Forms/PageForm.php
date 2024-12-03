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
    public array $site_id = [];

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
                'array',
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
        $this->site_id = $sitePage->sites()->pluck('id')->toArray();
    }

    public function setSitePageConfig($siteLayout)
    {
        $this->config = [];

        if ($siteLayout) {
            foreach ($siteLayout->config as $row) {
                if ($row['multiple']) {
                    $ids = \Arr::get($this->sitePage->config, $row['key'], []);
                    $ids = is_array($ids) ? $ids : [$ids];

                    $this->config[$row['key']] = array_values($ids);
                } else {
                    $id = \Arr::get($this->sitePage->config, $row['key']);
                    $id = is_array($id) ? \Arr::first($id) : $id;

                    $this->config[$row['key']] = $id;
                }
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = $this->except('sitePage', 'id', 'slugGenerated', 'site_id');

        $data['start_at'] = empty($data['start_at']) ? null : $data['start_at'];
        $data['end_at'] = empty($data['end_at']) ? null : $data['end_at'];

        if ($this->sitePage->id) {
            $this->sitePage->update($data);
        } else {
            $this->sitePage = SitePage::create($data);
        }

        $this->sitePage->sites()->sync($this->site_id);

        $this->setSitePage($this->sitePage);

        return $this->sitePage;
    }
}
