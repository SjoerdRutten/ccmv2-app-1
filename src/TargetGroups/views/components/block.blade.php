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

<div class="border border-gray-500 bg-gray-200 p-2 my-1 flex flex-col relative gap-2 rounded">
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

    <div class="flex flex-row gap-4">
        <x-ccm::buttons.success wire:click="addRule('{{ Arr::get($element, 'index') }}')"
                                icon="heroicon-s-plus"
        >
            Filter toevoegen
        </x-ccm::buttons.success>
        <x-ccm::buttons.warning wire:click="removeElement('{{ Arr::get($element, 'index') }}')"
                                icon="heroicon-s-x-circle"
        >
            Blok verwijderen
        </x-ccm::buttons.warning>
    </div>
</div>
