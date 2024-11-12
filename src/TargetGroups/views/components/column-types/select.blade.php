<x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
    <option value="">Kies operator</option>
    <option value="eq">Gelijk aan</option>
    <option value="ne">Niet gelijk aan</option>
</x-ccm::forms.select>

<x-ccm::forms.select name="value" wire:model.live="filter.value">
    <option></option>
    @foreach ($options AS $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</x-ccm::forms.select>