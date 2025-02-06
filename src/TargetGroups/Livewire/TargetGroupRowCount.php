<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class TargetGroupRowCount extends Component
{
    public array $elements;

    public int $count;

    public TargetGroup $targetGroup;

    public function mount(TargetGroup $targetGroup)
    {
        $this->targetGroup = $targetGroup;

        if ($this->targetGroup->id) {
            $this->updateTargetGroupCount();
        } else {
            $this->updateCount($this->elements);
        }
    }

    #[On('update-count')]
    public function updateCount($elements)
    {
        $this->count = \TargetGroupSelector::count($elements);
    }

    public function updateTargetGroupCount()
    {
        $this->count = $this->targetGroup->number_of_results;
    }

    public function placeholder()
    {
        return <<<'HTML'
            <div>
                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><style>.spinner_b2T7{animation:spinner_xe7Q .8s linear infinite}.spinner_YRVV{animation-delay:-.65s}.spinner_c9oY{animation-delay:-.5s}@keyframes spinner_xe7Q{93.75%,100%{r:3px}46.875%{r:.2px}}</style><circle class="spinner_b2T7" cx="4" cy="12" r="3"/><circle class="spinner_b2T7 spinner_YRVV" cx="12" cy="12" r="3"/><circle class="spinner_b2T7 spinner_c9oY" cx="20" cy="12" r="3"/></svg>
            </div>
            HTML;
    }

    public function render()
    {
        return view('target-group::livewire.target-group-row-count');
    }
}
