<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filterTmp.operator" class="w-[170px]" :disabled="$disabled">
        <option value="">Kies operator</option>
        <option value="eqm">Gelijk aan 1 van</option>
        <option value="neqm">Niet gelijk aan 1 van</option>
    </x-ccm::forms.select>
    <x-ccm::forms.multiple-select name="filterTmp.value" :grow="true"
                                  :disabled="$disabled"></x-ccm::forms.multiple-select>
</div>