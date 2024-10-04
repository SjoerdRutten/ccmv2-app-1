<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail content">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('ems::emailcontents::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            TODO
        </x-ccm::tabs.base>
    </div>
</div>
