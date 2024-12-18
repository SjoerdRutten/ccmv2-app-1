<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Traits;

trait HasModals
{
    protected function showSuccessModal(string $title, ?string $message = null, ?string $href = null)
    {
        $this->dispatch('show-modal-success', title: $title, content: $message, href: $href);
    }

    protected function showErrorModal(string $title, ?string $message = null, ?string $href = null)
    {
        $this->dispatch('show-modal-error', title: $title, content: $message, href: $href);
    }
}
