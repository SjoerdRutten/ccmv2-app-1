<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Taakplanner">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::scheduler::add">Taak toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Actief</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($schedules AS $key => $schedule)
                    <x-ccm::tables.tr :route="route('admin::scheduler::edit', $schedule)">
                        <x-ccm::tables.td :first="true">{{ $schedule->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$schedule->is_active"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $schedule->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $schedule->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::scheduler::edit', $schedule)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
