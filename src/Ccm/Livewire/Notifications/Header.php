<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Notifications;

use Livewire\Component;

class Header extends Component
{
    public function render(): string
    {
        return <<<'blade'
            <a href="{{ route('ccm::notifications') }}" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500" wire:poll.5000ms>
                <span class="sr-only">View notifications</span>

                @if (Auth::user()->unreadNotifications()->count())
                    <x-heroicon-s-bell-alert class="h-6 w-6 text-gray-800"/>
                    <x-ccm::tags.success>{{ Auth::user()->unreadNotifications()->count() }}</x-ccm::tags.success>
                @else
                    <x-heroicon-s-bell class="h-6 w-6 text-gray-300"/>
                @endif
            </a>

blade;
    }
}
