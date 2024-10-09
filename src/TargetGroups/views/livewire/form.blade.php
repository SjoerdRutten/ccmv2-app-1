<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Doelgroep selector">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('target-groups::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0" :badge="$this->count()">
                    Query builder
                </x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Debug</x-ccm::tabs.nav-tab>
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


                <x-ccm::forms.form class="w-1/2 bg-gray-200 mt-10 p-4">
                    <x-ccm::forms.input name="tag" wire:model="tag">Kenmerk</x-ccm::forms.input>
                    <x-ccm::forms.input name="fieldName" wire:model="fieldName">Veld</x-ccm::forms.input>
                    <x-ccm::forms.input name="seperator" wire:model="seperator">Schijdingsteken</x-ccm::forms.input>
                    <x-ccm::buttons.primary wire:click.prevent="addTag" icon="heroicon-s-plus">
                        Tag toevoegen aan CRM kaarten
                    </x-ccm::buttons.primary>
                </x-ccm::forms.form>


            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                {{ $this->getQueryFilters() }}
            </x-ccm::tabs.tab-content>


        </x-ccm::tabs.base>
    </div>
</div>


{{--<div wire:loading.remove class="p-5">--}}
{{--    <div class="mb-8">--}}
{{--        Aantal resultaten:--}}
{{--        {{ $this->count() }}--}}
{{--    </div>--}}


{{--    <div class="mt-10">--}}
{{--        <h1 class="text-2xl font-bold">Eerste 10 CRM ID's</h1>--}}
{{--        <h3 class="italic">Bij klikken op een ID, CRM kaart openen in popup?</h3>--}}
{{--        @foreach ($this->exampleResults AS $row)--}}
{{--            <div>{{ $row->crm_id }}</div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}
