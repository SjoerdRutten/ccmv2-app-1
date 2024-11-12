@php
    $uniq = uniqid();
@endphp
<div class="flex gap-2 grow">
    <input type="hidden" wire:model="filter.operator"/>
    <label>
        <input type="radio" name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}" value="1"
               wire:model.live="filter.value"/>
        Ja
    </label>
    <label>
        <input type="radio" name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}" value="0"
               wire:model.live="filter.value"/>
        Nee
    </label>
</div>