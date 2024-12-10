<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filterTmp.operator" :disabled="$disabled">
        <option value="">Kies operator</option>
        <option value="eq">Insluiten</option>
        <option value="neq">Uitsluiten</option>
    </x-ccm::forms.select>
    <x-ccm::forms.select name="value" wire:model.live="filterTmp.value" :disabled="$disabled">
        <option value="">Selecteer doelgroep</option>
        @foreach ($targetGroups AS $targetGroup)
            <option value="{{ $targetGroup->id }}">
                {{ $targetGroup->name }}
            </option>
        @endforeach
    </x-ccm::forms.select>
</div>