<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
        <option value="">Kies operator</option>
        <option value="con">Bevat</option>
        <option value="dnc">Bevat niet</option>
        <option value="eqm">Gelijk aan 1 van</option>
        <option value="neqm">Niet gelijk aan 1 van</option>
    </x-ccm::forms.select>
    @if (($filter['operator'] === 'eqm') || ($filter['operator'] === 'neqm'))
        <x-ccm::forms.multiple-select name="filter.value" :grow="true"></x-ccm::forms.multiple-select>
    @else
        <x-ccm::forms.input name="filter.value{{ $filter['id'] }}" wire:model.blur="filter.value"
                            :grow="true"/>
    @endif
</div>