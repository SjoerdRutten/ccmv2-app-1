<?php

namespace Sellvation\CCMV2\Sites\Livewire\Imports;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SiteImport;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => null,
        'type' => null,
        'site_category_id' => null,
    ];

    public function updated($property, $value)
    {
        if (\Str::startsWith($property, 'filter.')) {
            $this->resetPage();
        }
    }

    public function getImports()
    {
        return SiteImport::query()
            ->when($this->filter['q'], function ($query) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->when($this->filter['site_category_id'], function ($query) {
                $query->where('site_category_id', $this->filter['site_category_id']);
            })
            ->when($this->filter['type'], function ($query) {
                $query->where('type', $this->filter['type']);
            })
            ->paginate();
    }

    public function render()
    {
        return view('sites::livewire.imports.overview')
            ->with([
                'siteCategories' => SiteCategory::all(),
                'imports' => $this->getImports(),
            ]);
    }
}
