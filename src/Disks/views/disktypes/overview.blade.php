<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Disktypes">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::disktypes::add">Disktype toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Disk</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($diskTypes AS $key => $diskType)
                    <x-ccm::tables.tr :route="route('admin::disktypes::edit', $diskType)">
                        <x-ccm::tables.td :first="true">{{ $diskType->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $diskType->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $diskType->disk?->type }} - {{ $diskType->disk?->name }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::disktypes::edit', $diskType)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
