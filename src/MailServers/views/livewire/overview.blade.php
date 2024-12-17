<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Mail servers">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::mailservers::add">Mailserver toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Actief</x-ccm::tables.th>
                <x-ccm::tables.th>Valide</x-ccm::tables.th>
                <x-ccm::tables.th>Host</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Queue</x-ccm::tables.th>
                <x-ccm::tables.th>Deferred queue</x-ccm::tables.th>
                <x-ccm::tables.th>Load</x-ccm::tables.th>
                <x-ccm::tables.th>Memory</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($mailServers AS $key => $mailServer)
                    <x-ccm::tables.tr :route="route('admin::mailservers::edit', $mailServer)">
                        <x-ccm::tables.td :first="true">{{ $mailServer->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$mailServer->is_active"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$mailServer->is_valid"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $mailServer->host }}
                            <x-slot:sub>{{ $mailServer->private_ip }}</x-slot:sub>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $mailServer->description }}
                        </x-ccm::tables.td>
                        @if ($mailServer->mailServerStat && $mailServer->is_active)
                            <x-ccm::tables.td>{{ $mailServer->mailServerStat->queue_size }}</x-ccm::tables.td>
                            <x-ccm::tables.td>{{ $mailServer->mailServerStat->deferred_queue_size }}</x-ccm::tables.td>
                            <x-ccm::tables.td>{{ $mailServer->mailServerStat->load * 100 }} %</x-ccm::tables.td>
                            <x-ccm::tables.td>
                                {{ round(100 - (($mailServer->mailServerStat->memory_free / $mailServer->mailServerStat->memory_total) * 100)) }}
                                %
                            </x-ccm::tables.td>
                        @else
                            <x-ccm::tables.td></x-ccm::tables.td>
                            <x-ccm::tables.td></x-ccm::tables.td>
                            <x-ccm::tables.td></x-ccm::tables.td>
                            <x-ccm::tables.td></x-ccm::tables.td>
                        @endif
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::mailservers::edit', $mailServer)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
