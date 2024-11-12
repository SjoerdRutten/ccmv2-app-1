<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
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
            <x-ccm::forms.input type="text" step="1" name="filter.from" wire:model.blur="filter.from"/>
            <x-ccm::forms.input type="text" step="1" name="filter.to" wire:model.blur="filter.to"/>
        @else
            <x-ccm::forms.input type="text"
                                step="1"
                                name="filter.value"
                                wire:model.blur="filter.value"
                                :grow="true"/>
        @endif
    @endif
</div>