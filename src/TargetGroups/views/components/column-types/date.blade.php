<div class="flex gap-2 grow items-center">
    <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]" :disabled="$disabled">
        <option value="">Kies operator</option>
        <option value="gt">Groter dan</option>
        <option value="gte">Groter of gelijk</option>
        <option value="lt">Kleiner dan</option>
        <option value="lte">Kleiner of gelijk</option>
        <option value="eq">Gelijk aan</option>
        <option value="ne">Niet gelijk aan</option>
        <option value="between">Tussen</option>
    </x-ccm::forms.select>

    @if (Arr::get($filter, 'operator'))
        @if (Arr::get($filter, 'operator') === 'between')
            <x-ccm::forms.input-date name="filter.from" wire:model="filter.from" :disabled="$disabled"/>
            <x-ccm::forms.input-date name="filter.to" wire:model="filter.to" :disabled="$disabled"/>
        @else
            <x-ccm::forms.input-date name="filter.value" wire:model="filter.value" :disabled="$disabled"/>
        @endif
        @if (!$disabled)
            <div x-data
                 x-tooltip="Je kan hier ook een beschrijving geven (in het engels) b.v. -5 months of -3 days of next sunday">
                <x-heroicon-s-question-mark-circle class="w-6 h-6 text-pink-700"/>
            </div>
        @endif
    @endif
</div>
@once
    @push('js')
        <!-- Tippy.js -->
        <!-- https://atomiks.github.io/tippyjs/v6 -->
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
        @if (app()->environment('local'))
            <script defer src="/vendor/ccm/js/alpinejs-tooltip.js"></script>
        @else
            <script defer src="/vendor/ccm/js/alpinejs-tooltip.min.js"></script>
        @endif
    @endpush
@endonce