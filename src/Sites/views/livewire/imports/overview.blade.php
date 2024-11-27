<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="JS/CSS">
            <x-slot:actions>
                <x-ccm::buttons.add route="cms::imports::add">JS/CSS toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
            <div class="flex gap-4">
                <x-ccm::forms.select label="Soort" wire:model.live="filter.type">
                    <option></option>
                    <option value="js">Javascript</option>
                    <option value="css">Stylesheet</option>
                </x-ccm::forms.select>


                @if (count($siteCategories))
                    <x-ccm::forms.select label="Rubriek" wire:model.live="filter.site_category_id">
                        <option></option>
                        @foreach ($siteCategories AS $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                @endif
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
                <x-ccm::tables.th>Type</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($imports AS $key => $import)
                    <x-ccm::tables.tr :route="route('cms::imports::edit', $import)">
                        <x-ccm::tables.td :first="true">{{ $import->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $import->type }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $import->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $import->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('cms::imports::edit', $import)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $imports->links() }}
    </div>
</div>
