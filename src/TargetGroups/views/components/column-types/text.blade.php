<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filter.operator">
        <option value="">Kies operator</option>
        <option value="con">Bevat</option>
        <option value="dnc">Bevat niet</option>
        <option value="sw">Begint met</option>
        <option value="snw">Begint niet met</option>
        <option value="ew">Eindigt op</option>
        <option value="enw">Eindigt niet op</option>
        <option value="neq">Niet gelijk aan</option>
        <option value="eq">Gelijk aan</option>
        <option value="eqm">Gelijk aan 1 van</option>
        <option value="neqm">Niet gelijk aan 1 van</option>
    </x-ccm::forms.select>
    <x-ccm::forms.input name="filter.value" wire:model.blur="filter.value" :grow="true"/>
</div>