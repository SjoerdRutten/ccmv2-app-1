<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filterTmp.operator" :disabled="$disabled">
        <option value="">Kies operator</option>
        <option value="con">Bevat</option>
        <option value="dnc">Bevat niet</option>
        <option value="sw">Begint met</option>
        <option value="snw">Begint niet met</option>
        <option value="ew">Eindigt op</option>
        <option value="enw">Eindigt niet op</option>
        <option value="neq">Niet gelijk aan</option>
        <option value="eq">Gelijk aan</option>
        {{--        <option value="eqm">Gelijk aan 1 van</option>--}}
        {{--        <option value="neqm">Niet gelijk aan 1 van</option>--}}
        <option value="empty">Leeg</option>
        <option value="notempty">Niet leeg</option>
    </x-ccm::forms.select>
    @if (!\Illuminate\Support\Str::endsWith($filter['operator'], 'empty'))
        <x-ccm::forms.input name="filterTmp.value" wire:model.blur="filterTmp.value" :grow="true"
                            :disabled="$disabled"/>
    @endif
</div>