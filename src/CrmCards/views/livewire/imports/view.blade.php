<div wire:loading.remove x-data="{ show: false }">
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Import rapportage">
            <x-slot:actions>
                <x-ccm::buttons.secundary href="{{ route('crm-cards::imports::overview') }}">
                    Terug
                </x-ccm::buttons.secundary>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/4">
                    <x-ccm::definition-list.row>
                        <x-slot:title>Status</x-slot:title>
                        @switch($crmCardImport->status)
                            @case (0)
                                In wachtrij
                                @break
                            @case (1)
                                Bezig
                                @break
                            @case (2)
                                Gereed
                                @break
                        @endswitch
                    </x-ccm::definition-list.row>
                    <x-ccm::definition-list.row>
                        <x-slot:title>Bestandsnaam</x-slot:title>
                        {{ $crmCardImport->file_name }}
                    </x-ccm::definition-list.row>
                    <x-ccm::definition-list.row>
                        <x-slot:title>Totaal aantal rijen</x-slot:title>
                        {{ $crmCardImport->number_of_rows }}
                    </x-ccm::definition-list.row>
                    <x-ccm::definition-list.row>
                        <x-slot:title>Kaarten geupdate</x-slot:title>
                        {{ $crmCardImport->quantity_updated_rows }}
                    </x-ccm::definition-list.row>
                    <x-ccm::definition-list.row>
                        <x-slot:title>Kaarten aangemaakt</x-slot:title>
                        {{ $crmCardImport->quantity_created_rows }}
                    </x-ccm::definition-list.row>
                    <x-ccm::definition-list.row>
                        <x-slot:title>Lege rijen</x-slot:title>
                        {{ $crmCardImport->quantity_empty_rows }}
                    </x-ccm::definition-list.row>
                    <x-ccm::definition-list.row>
                        <x-slot:title>Rijen met fouten</x-slot:title>
                        {{ $crmCardImport->quantity_error_rows }}
                    </x-ccm::definition-list.row>
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
