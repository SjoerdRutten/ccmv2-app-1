<?php

namespace Sellvation\CCMV2\Ccm\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class ModalError extends Component
{
    public string $title = '';

    public ?string $content = null;

    public ?string $href = null;

    public bool $showModal = false;

    #[On('show-modal-error')]
    public function showModalError($title, $content = null, $href = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->href = $href;

        $this->showModal = true;
    }

    public function render()
    {
        return view('ccm::livewire.modal-error');
    }
}
