<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Verzendregels">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::sendrules::add">Verzendregel toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Actief</x-ccm::tables.th>
                <x-ccm::tables.th>Priority</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($sendRules AS $key => $sendRule)
                    <x-ccm::tables.tr :route="route('admin::sendrules::edit', $sendRule)">
                        <x-ccm::tables.td :first="true">{{ $sendRule->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$sendRule->is_active"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $key + 1 }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $sendRule->name }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::sendrules::edit', $sendRule)"/>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze verzendregel wilt verwijderen?"
                                    wire:click="remove({{ $sendRule->id }})"
                            />
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
