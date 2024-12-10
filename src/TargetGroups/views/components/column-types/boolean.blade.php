@php
    $uniq = uniqid();
@endphp
<div class="flex gap-2 grow {{ $disabled ? 'text-gray-400' : '' }}">
    <input type="hidden" wire:model="filterTmp.operator"/>
    <label>
        <input type="radio"
               name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}"
               value="1"
               wire:model.live="filterTmp.value"
                {{ $disabled ? 'disabled' : '' }}
        />
        Ja
    </label>
    <label>
        <input type="radio"
               name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}"
               value="0"
               wire:model.live="filterTmp.value"
                {{ $disabled ? 'disabled' : '' }}
        />
        Nee
    </label>
</div>