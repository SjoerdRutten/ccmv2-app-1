<div class="flex gap-2 grow">
    <x-ccm::forms.select name="value" wire:model.live="filter.value">
        <option value="">Selecteer doelgroep</option>
        @foreach ($targetGroups AS $targetGroup)
            <option value="{{ $targetGroup->id }}">
                {{ $targetGroup->name }}
            </option>
        @endforeach
    </x-ccm::forms.select>
</div>