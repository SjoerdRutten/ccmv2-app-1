@php
    $uniq = uniqid();
@endphp
<div class="flex gap-2 grow {{ $disabled ? 'text-gray-400' : '' }}">
    <input type="hidden" wire:model="filter.operator"/>
    <label>
        <input type="radio"
               name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}"
               value="1"
               wire:model.live="filter.value"
                {{ $disabled ? 'disabled' : '' }}
        />
        Ja
    </label>
    <label>
        <input type="radio"
               name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}"
               value="0"
               wire:model.live="filter.value"
                {{ $disabled ? 'disabled' : '' }}
        />
        Nee
    </label>
</div>