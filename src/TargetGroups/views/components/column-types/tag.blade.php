<div class="flex gap-2 grow">
    <x-ccm::forms.select name="value" wire:model.live="filterTmp.value" :disabled="$disabled">
        <option value="">Selecteer kenmerk</option>
        @foreach ($tags AS $tag)
            <option value="{{ $tag->id }}">
                {{ $tag->name }}
            </option>
        @endforeach
    </x-ccm::forms.select>
</div>