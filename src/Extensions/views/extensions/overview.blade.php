<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Extensies">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::extensions::add">Extensie toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Actief</x-ccm::tables.th>
                <x-ccm::tables.th>Starttijd</x-ccm::tables.th>
                <x-ccm::tables.th>Eindtijd</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($extensions AS $key => $extension)
                    <x-ccm::tables.tr :route="route('admin::extensions::edit', $extension)">
                        <x-ccm::tables.td :first="true">{{ $extension->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$extension->show_active"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $extension->start_at?->toDateTimeString() }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $extension->end_at?->toDateTimeString() }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $extension->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $extension->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::extensions::edit', $extension)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
