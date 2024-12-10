<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class TargetGroupRowCount extends Component
{
    public array $elements;

    public int $count;

    public function mount()
    {
        $this->updateCount($this->elements);
    }

    #[On('update-count')]
    public function updateCount($elements)
    {
        $this->count = \TargetGroupSelector::count($elements);
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
        return <<<'HTML'
            <div>
                {{ ReadableNumber($this->count, '.') }}
            </div>
            HTML;
    }
}
