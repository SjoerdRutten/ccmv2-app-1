<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Disks">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::disks::add">Disk toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filter.q"
                        wire:model.live="filter.q"
                >
                    Zoeken
                </x-ccm::forms.input>
            </div>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Soort</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($disks AS $key => $disk)
                    <x-ccm::tables.tr :route="route('admin::disks::edit', $disk)">
                        <x-ccm::tables.td :first="true">{{ $disk->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $disk->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $disk->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $disk->type }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::disks::edit', $disk)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
