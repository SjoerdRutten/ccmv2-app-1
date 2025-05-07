<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Servers">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::servers::add">server toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Type</x-ccm::tables.th>
                <x-ccm::tables.th class="text-center" style="width: 100px;">CPU</x-ccm::tables.th>
                <x-ccm::tables.th class="text-center" style="width: 100px;">Disk</x-ccm::tables.th>
                <x-ccm::tables.th class="text-center" style="width: 100px;">RAM</x-ccm::tables.th>
                <x-ccm::tables.th></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($servers AS $key => $server)
                    <x-ccm::tables.tr :route="route('admin::servers::edit', $server)">
                        <x-ccm::tables.td :first="true">
                            {{ $server->name }}
                            <x-slot:sub>{{ $server->ip }}</x-slot:sub>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $server->type }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::charts.radial-bar :percentage="$server->cpuPercentage"
                                                      :height="60"
                                                      ref="chartCpu{{ $server->id }}"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::charts.radial-bar :percentage="$server->diskFreePercentage"
                                                      :height="60"
                                                      ref="chartDisk{{ $server->id }}"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::charts.radial-bar :percentage="$server->ramFreePercentage"
                                                      :height="60"
                                                      ref="chartRam{{ $server->id }}"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link
                                    :href="route('admin::servers::edit', $server)"></x-ccm::tables.edit-link>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze server wilt verwijderen?"
                                    wire:click="removeServer({{ $server->id }})"></x-ccm::tables.delete-link>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
