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
                <x-ccm::tables.th>Laatste run</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Interval</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($schedules AS $key => $schedule)
                    <x-ccm::tables.tr :route="route('admin::scheduler::edit', $schedule)">
                        <x-ccm::tables.td :first="true">{{ $schedule->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$schedule->is_active"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @if ($schedule->scheduledTaskLogs()->first())
                                <x-ccm::is-active :is-active="$schedule->scheduledTaskLogs()->first()->is_success"/>
                                <x-slot:sub>
                                    {{ $schedule->scheduledTaskLogs()->first()->created_at }}
                                </x-slot:sub>
                            @else
                                Nooit uitgevoerd
                            @endif
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $schedule->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $schedule->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ Arr::get($schedule->pattern, 'type') }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::scheduler::edit', $schedule)"/>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze taak wilt verwijderen?"
                                    wire:click.prevent="remove({{ $schedule->id }})"
                            />
                            <x-ccm::tables.run-link
                                    wire:confirm="Weet je zeker dat je deze taak wilt starten?"
                                    wire:click.prevent="run({{ $schedule->id }})"
                            />
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
