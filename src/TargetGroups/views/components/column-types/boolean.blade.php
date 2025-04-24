@php
    $uniq = uniqid();
@endphp
<div class="flex gap-2 grow {{ $disabled ? 'text-gray-400' : '' }}">
    <x-ccm::forms.select name="operator" wire:model.live="filterTmp.operator" class="w-[170px]" :disabled="$disabled">
        <option value="">Kies operator</option>
        <option value="eq">Gelijk aan</option>
        <option value="eqe">Gelijk aan of leeg</option>
    </x-ccm::forms.select>
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