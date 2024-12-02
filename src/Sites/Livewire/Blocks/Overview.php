<?php

namespace Sellvation\CCMV2\Sites\Livewire\Blocks;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Sites\Models\SiteBlock;
use Sellvation\CCMV2\Sites\Models\SiteCategory;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => null,
        'site_category_id' => null,
    ];

    public function updated($property, $value)
    {
        if (\Str::startsWith($property, 'filter.')) {
            $this->resetPage();
        }
    }

    public function duplicateBlock(SiteBlock $siteBlock)
    {
        $newBlock = $siteBlock->replicate();
        $newBlock->name = $newBlock->name.' (kopie)';
        $newBlock->save();

        $this->redirectRoute('cms::blocks::edit', $newBlock);
    }

    public function removeBlock(SiteBlock $siteBlock)
    {
        $siteBlock->delete();
    }

    public function getBlocks()
    {
        return SiteBlock::query()
            ->when($this->filter['q'], function ($query) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->when($this->filter['site_category_id'], function ($query) {
                $query->where('site_category_id', $this->filter['site_category_id']);
            })
            ->paginate();
    }

    public function render()
    {
        return view('sites::livewire.blocks.overview')
            ->with([
                'siteCategories' => SiteCategory::all(),
                'blocks' => $this->getBlocks(),
            ]);
    }
}
