<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM Velden">
            <div class="flex gap-4">
                <x-ccm::forms.select label="Rubriek" wire:model.live="filter.crm_field_category_id">
                    <option></option>
                    @foreach ($crmFieldCategories AS $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoek op naam of omschrijving</x-ccm::forms.input>
            </div>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Type</x-ccm::tables.th>
                <x-ccm::tables.th>Overzicht</x-ccm::tables.th>
                <x-ccm::tables.th>Doelgroep selector</x-ccm::tables.th>
                <x-ccm::tables.th>CRM-Kaart</x-ccm::tables.th>
                <x-ccm::tables.th>Vergrendelen</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($crmFields AS $key => $crmField)
                    <tr>
                        <x-ccm::tables.td :first="true">
                            {{ $crmField['id'] }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $crmField['name'] }}
                            <x-slot:sub>
                                {{ \Illuminate\Support\Arr::get($crmField, 'crm_field_category.name') }}
                            </x-slot:sub>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td class="max-w-[150px] truncate ..." title="{{ $crmField['label'] }}">{{ $crmField['label'] }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmField['crm_field_type']['name'] }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::forms.checkbox
                                    wire:model.live="crmFields.{{ $key }}.is_shown_on_overview"
                                    wire:target="crmFields"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                            />
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::forms.checkbox
                                    wire:model.live="crmFields.{{ $key }}.is_shown_on_target_group_builder"
                                    wire:target="crmFields"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                            />
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::forms.checkbox
                                    wire:model.live="crmFields.{{ $key }}.is_hidden"
                                    wire:target="crmFields"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                            />
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::forms.checkbox
                                    wire:model.live="crmFields.{{ $key }}.is_locked"
                                    wire:target="crmFields"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                            />
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('crm-cards::fields::edit', $crmField['id'])" />
                        </x-ccm::tables.td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
