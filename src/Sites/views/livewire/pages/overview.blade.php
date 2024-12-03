<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Pagina's">
            <x-slot:actions>
                <x-ccm::buttons.add route="cms::pages::add">Pagina toevoegen</x-ccm::buttons.add>
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
                <x-ccm::tables.th>Site</x-ccm::tables.th>
                <x-ccm::tables.th>Online</x-ccm::tables.th>
                <x-ccm::tables.th>Slug</x-ccm::tables.th>
                <x-ccm::tables.th>Publicatie</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($pages AS $key => $page)
                    <x-ccm::tables.tr :route="route('cms::pages::edit', $page)">
                        <x-ccm::tables.td :first="true">{{ $page->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $page->name }}
                            <x-slot:sub>{{ $page->description }}</x-slot:sub>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <ul>
                                @foreach($page->sites AS $site)
                                    <li>{{ $site->name }}</li>
                                @endforeach
                            </ul>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @if ($page->isOnline)
                                <x-ccm::tags.success>Online</x-ccm::tags.success>
                            @else
                                <x-ccm::tags.error>Offline</x-ccm::tags.error>
                            @endif
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $page->slug }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $page->start_at?->toDateTimeString('minutes') }}
                            @if ($page->start_at && $page->end_at)
                                t/m
                            @endif
                            {{ $page->end_at?->toDateTimeString('minutes') }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('cms::pages::edit', $page)"/>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze pagina wilt verwijderen ?"
                                    wire:click="removePage({{ $page->id }})"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $pages->links() }}
    </div>
</div>
