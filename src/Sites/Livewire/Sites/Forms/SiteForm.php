<?php

namespace Sellvation\CCMV2\Sites\Livewire\Sites\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Sites\Models\Site;

class SiteForm extends Form
{
    use WithFileUploads;

    public Site $site;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public $site_page_id;

    #[Validate]
    public $name;

    #[Validate]
    public $description;

    #[Validate]
    public $domain;

    #[Validate]
    public $favicon;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'site_page_id' => [
                'nullable',
                'exists:site_pages,id',
            ],
            'name' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'domain' => [
                'nullable',
            ],
            'favicon' => [
                'nullable',
            ],
        ];
    }

    public function setSite(Site $site)
    {
        $this->site = $site;

        $this->fill($site->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->only('name', 'description', 'domain', 'site_page_id');

        if (is_object($this->favicon) && $this->favicon->isValid()) {
            $fileName = uniqid().'.'.$this->favicon->extension();
            $this->favicon->storeAs(path: config('ccm.sites.favicon_path'), name: $fileName, options: ['disk' => config('ccm.sites.favicon_disk')]);

            $data['favicon_disk'] = config('ccm.sites.favicon_disk');
            $data['favicon'] = config('ccm.sites.favicon_path').$fileName;
        }

        if ($this->site->id) {
            $this->site->update($data);
        } else {
            $this->site = Site::create($data);
        }

        $this->setSite($this->site);

        return $this->site;
    }
}
