<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM kaarten">
            <x-slot:actions>
                <x-ccm::buttons.add route="crm-cards::cards::add">CRM Kaart toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.blur="filter.q"
                >
                    Zoeken
                </x-ccm::forms.input>
                <x-ccm::forms.select label="Zoekveld" wire:model.live="filter.crm_field_id">
                    <option>-Alle geindexeerde velden-</option>
                    @foreach ($searchableCrmFields AS $crmField)
                        <option value="{{ $crmField->id }}">
                            {{ Str::replace('_', ' ', $crmField->name) }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>
                @if (count($targetGroups) > 0)
                    <x-ccm::forms.select label="Doelgroep selectie" wire:model.live="filter.target_group_id">
                        <option></option>
                        @foreach ($targetGroups AS $targetGroup)
                            <option value="{{ $targetGroup->id }}">
                                {{ $targetGroup->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                @endif
            </div>
        </x-ccm::pages.intro>

        @dump($sort)

        <x-ccm::loading/>
        <x-ccm::tables.table wire:loading.remove>
            <x-slot:thead>
                @foreach ($crmFields AS $key => $crmField)
                    <x-ccm::tables.th :first="$key === 0">
                        <div class="flex">
                            <a href="#" wire:click.prevent="setOrder('{{ $crmField->name }}')" class="hover:underline">
                                {{ Str::replace('_', ' ', $crmField->name) }}
                            </a>
                            @if ($sort['column'] === $crmField->name)
                                @if ($sort['direction'] === 'asc')
                                    <x-heroicon-c-chevron-down class="w-4 h-4 inline"/>
                                @else
                                    <x-heroicon-c-chevron-up class="w-4 h-4 inline"/>
                                @endif
                            @endif
                        </div>
                    </x-ccm::tables.th>
                @endforeach
                <x-ccm::tables.th></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($crmCards AS $key => $card)
                    <x-ccm::tables.tr :route="route('crm-cards::cards::edit', $card)">
                        @foreach ($crmFields AS $crmField)
                            <x-ccm::tables.td>
                                {{ \Illuminate\Support\Arr::get($card->data, $crmField->name) }}
                            </x-ccm::tables.td>
                        @endforeach
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('crm-cards::cards::edit', $card)"/>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze kaart wilt verwijderen?"
                                    wire:click="removeCard({{ $card->id }})"
                            />
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $crmCards->links() }}
    </div>
</div>
