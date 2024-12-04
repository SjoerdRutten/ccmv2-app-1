<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Scrapers">
            <x-slot:actions>
                <x-ccm::buttons.add route="cms::scrapers::add">Scraper toevoegen</x-ccm::buttons.add>
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
                <x-ccm::tables.th>Doel</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Status</x-ccm::tables.th>
                <x-ccm::tables.th>Laatste scrape</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($scrapers AS $key => $scraper)
                    <x-ccm::tables.tr :route="route('cms::scrapers::edit', $scraper)">
                        <x-ccm::tables.td :first="true">{{ $scraper->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $scraper->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $scraper->target }}
                            @if ($scraper->target === 'layout')
                                <x-slot:sub>
                                    @if ($scraper->siteLayout)
                                        <x-ccm::layouts.link
                                                :href="route('cms::layouts::edit', $scraper->siteLayout)">{{ $scraper->siteLayout?->name }}</x-ccm::layouts.link>
                                    @else
                                        {{ $scraper->layout_name }} (nieuw)
                                    @endif
                                </x-slot:sub>
                            @else
                                <x-slot:sub>
                                    @if ($scraper->siteBlock)
                                        <x-ccm::layouts.link
                                                :href="route('cms::blocks::edit', $scraper->siteBlock)"
                                        >{{ $scraper->siteBlock?->name }}</x-ccm::layouts.link>
                                    @else
                                        {{ $scraper->block_name }} (nieuw)
                                    @endif
                                </x-slot:sub>
                            @endif
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $scraper->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @if ($scraper->status === 'new')
                                <x-ccm::tags.ccm>Nieuw</x-ccm::tags.ccm>
                            @elseif ($scraper->status === 'running')
                                <x-ccm::tags.warning>Running</x-ccm::tags.warning>
                            @elseif ($scraper->status === 'failed')
                                <x-ccm::tags.error>Mislukt</x-ccm::tags.error>
                            @elseif ($scraper->status === 'done')
                                <x-ccm::tags.success>Gereed</x-ccm::tags.success>
                            @endif
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $scraper->last_scraped_at?->toDateTimeString('minute') }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('cms::scrapers::edit', $scraper)"/>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze scraper wilt verwijderen ? Gekoppelde layouts en contentblokken zullen niet verwijderd worden."
                                    wire:click="removeScraper({{ $scraper->id }})"
                            />
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $scrapers->links() }}
    </div>
</div>
