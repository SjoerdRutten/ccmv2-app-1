<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Categories;

use Livewire\Attributes\Url;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;

class Overview extends Component
{
    #[Url]
    public array $filter = [
        'q' => null,
    ];

    public function reOrderCategories($id, $position)
    {
        $crmFieldCategory = CrmFieldCategory::find($id);
        $crmFieldCategory->update(['position' => $position]);

        $index = 0;
        foreach (CrmFieldCategory::where('id', '<>', $id)->orderBy('position')->get() as $category) {
            if ($index === $position) {
                $index++;
            }
            $category->update(['position' => $index]);
            $index++;
        }
    }

    public function getCategories()
    {
        return CrmFieldCategory::query()
            ->when($this->filter['q'], function ($query) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%');
            })
            ->orderBy('position')
            ->get();
    }

    public function remove(CrmFieldCategory $category)
    {
        $category->delete();
    }

    public function render()
    {
        return view('crm-cards::livewire.categories.overview')
            ->with([
                'categories' => $this->getCategories(),
            ]);
    }
}
