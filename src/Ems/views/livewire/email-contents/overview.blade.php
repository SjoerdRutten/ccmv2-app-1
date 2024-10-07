<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail content">
            <div class="flex gap-4">
                <x-ccm::forms.select label="Rubriek" wire:model.live="filter.email_category_id">
                    <option></option>
                    @foreach ($emailCategories AS $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>
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
                <x-ccm::tables.th>Laatste update</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($emailContents AS $key => $content)
                    <x-ccm::tables.tr :route="route('ems::emailcontents::edit', $content)">
                        <x-ccm::tables.td :first="true">{{ $content->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <x-ccm::is-active :is-active="$content->isActive"/>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $content->name }}
                            <x-slot:sub>
                                {{ $content->emailCategory->name }}
                            </x-slot:sub>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $content->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $content->updated_at }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('ems::emailcontents::edit', $content)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $emailContents->links() }}
    </div>
</div>
