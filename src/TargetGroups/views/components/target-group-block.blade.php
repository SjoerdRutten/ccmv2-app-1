@props([
    'elements'
])

@foreach ($elements AS $key => $element)
    @if (Arr::get($element, 'type') === 'block')
        <livewire:target-group-selector::block
                wire:model="elements.{{ $key }}"
                wire:key="{{ hash('md5', serialize($element)) }}"
                index="{{ $key }}"
        />
    @endif
@endforeach
