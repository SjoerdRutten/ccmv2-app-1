<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Mailings">
            <x-slot:actions>
                <x-ccm::buttons.add route="ems::mailings::add">Mailing toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoeken
                </x-ccm::forms.input>
            </div>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th></x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Verzendtijd</x-ccm::tables.th>
                <x-ccm::tables.th>Status</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>

            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $mailings->links() }}
    </div>
</div>
