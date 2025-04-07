<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Doelgroep selecties">
            <x-slot:actions>
                <x-ccm::buttons.add route="target-groups::form">Doelgroep selectie toevoegen</x-ccm::buttons.add>
            </x-slot:actions>

            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoek op naam
                </x-ccm::forms.input>
                <x-ccm::forms.select
                        name="categoryId"
                        wire:model.live="filter.category_id"
                        label="Categorie">
                    <option></option>
                    {{--                    <option value="-1">Zonder categorie</option>--}}
                    @foreach ($categories AS $key => $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>
            </div>

        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Categorie</x-ccm::tables.th>
                <x-ccm::tables.th width="30%">Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Aantal resultaten</x-ccm::tables.th>
                <x-ccm::tables.th>Creatietijd</x-ccm::tables.th>
                <x-ccm::tables.th>Updatetijd</x-ccm::tables.th>
                <x-ccm::tables.th :link="true"></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($this->targetGroups AS $targetGroup)
                    <x-ccm::tables.tr :route="route('target-groups::form', $targetGroup)">
                        <x-ccm::tables.td :first="true">{{ $targetGroup->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $targetGroup->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $targetGroup->category?->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td
                                class="text-wrap">{{ $targetGroup->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{--                            <livewire:target-group-selector::target-group-row-count--}}
                            {{--                                    :elements="$targetGroup->filters"--}}
                            {{--                                    :targetGroup="$targetGroup"--}}
                            {{--                                    wire:key="COUNT{{ $targetGroup->id }}"--}}
                            {{--                                    lazy--}}
                            {{--                            />--}}
                            <livewire:target-group-selector::target-group-row-count
                                    :targetGroupId="$targetGroup->id"
                                    wire:key="COUNT{{ $targetGroup->id }}"
                                    lazy
                            />
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $targetGroup->created_at->toDateTimeString() }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $targetGroup->updated_at->toDateTimeString() }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <div class="flex flex-row-reverse gap-4">
                                <x-ccm::tables.edit-link :href="route('target-groups::form', $targetGroup)"/>
                                <x-ccm::tables.delete-link wire:click="delete({{ $targetGroup->id }})"
                                                           wire:confirm="Weet je zeker dat je deze doelgroep wilt verwijderen ?"/>
                            </div>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
