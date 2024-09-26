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

<div class="border border-blue-500 bg-blue-200 p-4 my-1 flex flex-col relative">
    @if ($index !== 0)
        <div class="absolute -top-[18px] bg-white border border-blue-500 px-2">
            OF
        </div>
    @endif
    <div class="flex flex-col">
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
{{--        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"--}}
{{--                wire:click="addSubBlock('{{ Arr::get($element, 'index') }}')"--}}
{{--        >--}}
{{--            Blok toevoegen--}}
{{--        </button>--}}
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                wire:click="addRule('{{ Arr::get($element, 'index') }}')"
        >
            Filter toevoegen
        </button>
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                wire:click="removeElement('{{ Arr::get($element, 'index') }}')"
        >
            Blok verwijderen
        </button>
    </div>
</div>
