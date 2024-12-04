<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Rubrieken">
            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoek op naam of omschrijving
                </x-ccm::forms.input>
            </div>

            <x-slot:actions>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table :sortable="true"
                             x-data="{ handle: (item, position) => { $wire.reOrderCategories(item, position) } }">
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th :link="true"></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($categories AS $key => $category)
                    <x-ccm::tables.tr :route="route('crm-cards::categories::edit', $category)" :id="$category->id">
                        <x-ccm::tables.td :first="true">
                            {{ $category->id }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $category->name }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('crm-cards::categories::edit', $category)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
