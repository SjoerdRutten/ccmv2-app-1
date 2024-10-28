<div class="mb-4">
    @if (count($environments) > 1)
        <x-ccm::forms.select wire:model.live="environmentId">
            @foreach ($environments AS $environment)
                <option value="{{ $environment->id }}">
                    {{ $environment->name }}
                </option>
            @endforeach
        </x-ccm::forms.select>
    @endif
</div>