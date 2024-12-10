<x-ccm::forms.select name="operator" wire:model.live="filterTmp.operator" class="w-[170px]" :disabled="$disabled">
    <option value="">Kies operator</option>
    <option value="eq">Gelijk aan</option>
    <option value="ne">Niet gelijk aan</option>
</x-ccm::forms.select>

<x-ccm::forms.select name="value" wire:model.live="filterTmp.value" :disabled="$disabled">
    <option></option>
    @foreach ($options AS $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</x-ccm::forms.select>