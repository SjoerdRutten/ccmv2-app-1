<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Layouts">
            <x-slot:actions>
                <x-ccm::buttons.add route="cms::layouts::add">Layout toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
            <div class="flex gap-4">
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
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Webpagina's</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($layouts AS $key => $layout)
                    <x-ccm::tables.tr :route="route('cms::layouts::edit', $layout)">
                        <x-ccm::tables.td :first="true">{{ $layout->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $layout->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $layout->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $layout->sitePages()->count() }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('cms::layouts::edit', $layout)"/>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze layout wilt verwijderen ? LET OP: pagina's die gebruik maken van deze layout worden ook verwijderd!"
                                    wire:click="removeLayout({{ $layout->id }})"
                            />
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $layouts->links() }}
    </div>
</div>
