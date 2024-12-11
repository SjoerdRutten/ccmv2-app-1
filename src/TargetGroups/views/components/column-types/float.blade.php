<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filterTmp.operator" class="w-[170px]" :disabled="$disabled">
        <option value="">Kies operator</option>
        <option value="gt">Groter dan</option>
        <option value="gte">Groter of gelijk</option>
        <option value="lt">Kleiner dan</option>
        <option value="lte">Kleiner of gelijk</option>
        <option value="between">Tussen</option>
        <option value="eq">Gelijk aan</option>
        <option value="ne">Niet gelijk aan</option>
        <option value="eqm">Gelijk aan 1 van</option>
        <option value="neqm">Niet gelijk aan 1 van</option>
    </x-ccm::forms.select>

    @if (Arr::get($filter, 'operator'))
        @if (Arr::get($filter, 'operator') === 'between')
            <x-ccm::forms.input type="number" step="0.01" name="filterTmp.from" wire:model.blur="filterTmp.from"
                                :disabled="$disabled"/>
            <x-ccm::forms.input type="number" step="0.01" name="filterTmp.to" wire:model.blur="filterTmp.to"
                                :disabled="$disabled"/>
        @else
            <x-ccm::forms.input type="number"
                                step="0.01"
                                name="filterTmp.value"
                                wire:model.blur="filterTmp.value"
                                :grow="true"
                                :disabled="$disabled"/>
        @endif
    @endif
</div>