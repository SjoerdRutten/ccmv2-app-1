<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Doelgroep selector">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('target-groups::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0" :badge="ReadableNumber($count, '.')">
                    Query builder
                </x-ccm::tabs.nav-tab>
                @if (Auth::user()->isAdmin)
                    <x-ccm::tabs.nav-tab :index="1">Debug</x-ccm::tabs.nav-tab>
                @endif
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="name" wire:model="name">Naam</x-ccm::forms.input>
                </div>

                <div class="flex flex-col mt-10">
                    @foreach ($elements AS $key => $element)
                        <x-target-group::block :elements="$elements" :element="$element" :index="$key"/>
                    @endforeach
                </div>

                <x-ccm::buttons.primary wire:click="addBlock"
                                        icon="heroicon-s-plus"
                >
                    Blok toevoegen
                </x-ccm::buttons.primary>

                <x-slot:buttons>
                    <x-ccm::buttons.primary wire:click="showTagModal = true">
                        Kenmerk toevoegen aan selectie
                    </x-ccm::buttons.primary>
                </x-slot:buttons>

            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                {{ $this->getQueryFilters() }}
            </x-ccm::tabs.tab-content>


        </x-ccm::tabs.base>

        <div x-data="{ show: @entangle('showTagModal') }">
            <x-ccm::layouts.modal
                    title="Kenmerk toevoegen"
            >
                <x-ccm::forms.form class="w-full">
                    <x-ccm::forms.input name="tag" wire:model="tag">Kenmerk</x-ccm::forms.input>
                    <x-ccm::forms.input name="fieldName" wire:model="fieldName">Veld</x-ccm::forms.input>
                    <x-ccm::forms.input name="seperator" wire:model="seperator">Schijdingsteken</x-ccm::forms.input>
                </x-ccm::forms.form>

                <x-slot:buttons>
                    <x-ccm::buttons.primary wire:click.prevent="addTag">
                        Tag toevoegen aan CRM kaarten
                    </x-ccm::buttons.primary>
                    <x-ccm::buttons.secundary wire:click="showTagModal = false">
                        Annuleren
                    </x-ccm::buttons.secundary>
                </x-slot:buttons>
            </x-ccm::layouts.modal>
        </div>
    </div>
</div>
