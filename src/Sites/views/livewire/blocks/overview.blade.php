<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Contentblok">
            <x-slot:actions>
                <x-ccm::buttons.add route="cms::blocks::add">Contentblok toevoegen</x-ccm::buttons.add>
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
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($blocks AS $key => $block)
                    <x-ccm::tables.tr :route="route('cms::blocks::edit', $block)">
                        <x-ccm::tables.td :first="true">{{ $block->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $block->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $block->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('cms::blocks::edit', $block)"/>
                            <x-ccm::tables.delete-link wire:confirm="Weet je zeker dat je dit blok wilt verwijderen ?"
                                                       wire:click="removeBlock({{ $block->id }})"/>
                            <x-ccm::tables.duplicate-link wire:confirm="Wil je een kopie maken van dit contentblok ?"
                                                          wire:click="duplicateBlock({{ $block->id }})"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $blocks->links() }}
    </div>
</div>
