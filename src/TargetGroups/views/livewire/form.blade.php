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
                {{--                <x-ccm::tabs.nav-tab :index="1">Resultaten</x-ccm::tabs.nav-tab>--}}
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


                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        wire:click="addBlock"
                >
                    Blok toevoegen
                </button>
            </x-ccm::tabs.tab-content>

            <div class="text-xs italic">
                Gegenereerde query:
                {{ $this->getQueryFilters() }}
            </div>


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
