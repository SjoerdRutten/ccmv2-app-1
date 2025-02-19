<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Data feeds">
            <x-slot:actions>
                <x-ccm::buttons.add route="df::add">Data feed toevoegen</x-ccm::buttons.add>
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
                <x-ccm::tables.th>Actief</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Laatste fetch</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($dataFeeds AS $key => $dataFeed)
                    <x-ccm::tables.tr :route="route('df::edit', $dataFeed)">
                        <x-ccm::tables.td :first="true">{{ $dataFeed->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$dataFeed->is_active"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $dataFeed->name }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $dataFeed->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>TODO</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('df::edit', $dataFeed)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $dataFeeds->links() }}
    </div>
</div>
