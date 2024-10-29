@props([
    'elements' => [],
    'element' => [],
    'index' => null,
])
@php
    $baseIndex = $index;
    if (!Str::endsWith($index, '.subelements')) {
        $baseIndex = $index.'.subelements';
    }
@endphp

<div class="border border-gray-300 bg-gray-200 p-2 my-1 flex flex-col relative gap-2 rounded">
    @if ($index !== 0)
        <div class="absolute -top-[18px] bg-white border border-gray-500 px-2 rounded">
            OF
        </div>
    @endif

    <div class="flex flex-col gap-2">
        @foreach (Arr::get($element, 'subelements') AS $key => $sub)
            @if (Arr::get($sub, 'type') === 'block')
                <x-target-group::block :element="$sub" :index="$baseIndex.'.'.$key"/>
            @elseif (Arr::get($sub, 'type') === 'rule')
                <livewire:target-group-selector::rule
                        wire:model.live="elements.{{ $baseIndex }}.{{ $key }}"
                        :key="'elements.'.$baseIndex.'.'.$key"
                        :index="$baseIndex.'.'.$key"
                />
            @endif
        @endforeach
    </div>

    <div class="flex flex-row gap-4 mt-4">
        <a href="#" wire:click.prevent="addRule('{{ Arr::get($element, 'index') }}')">
            <x-heroicon-s-plus-circle class="w-5 h-5 inline"/>
            Criterium toevoegen
        </a>
        <a href="#"
           class="text-red-500"
           wire:confirm="Weet je zeker dat je dit blok wilt verwijderen ?"
           wire:click.prevent="removeElement('{{ Arr::get($element, 'index') }}')"
        >
            <x-heroicon-s-trash class="w-5 h-5 inline"/>
            Blok verwijderen
        </a>
    </div>
</div>
