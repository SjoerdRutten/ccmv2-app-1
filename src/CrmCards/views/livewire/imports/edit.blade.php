<div wire:loading.remove x-data="{ show: false }">
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Importeer bestand">
            <x-slot:actions>
                @if (count($rows))
                    <x-ccm::buttons.primary wire:click="startImport">Import starten</x-ccm::buttons.primary>
                @endif
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Data</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Velden</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                @if ($fileType === 'error')
                    <x-ccm::alerts.warning title="Ongeldig bestandstype" class="mt-4">
                        Geen geldig bestandstype, er kunnen alleen .csv, .xls en .xlsx geupload worden
                    </x-ccm::alerts.warning>
                @endif

                <x-ccm::forms.input-file wire:model.live="file">Bestand</x-ccm::forms.input-file>
                <x-ccm::loading/>

                @if ($fileType && ($fileType !== 'error'))
                    <x-ccm::typography.h2>Instellingen</x-ccm::typography.h2>

                    <x-ccm::forms.input value="{{ $file?->getClientOriginalName() }}" :disabled="true">
                        Bestandsnaam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select wire:model.live="config.has_header" label="Veldnamen op eerste regel">
                        <option value="1">Ja</option>
                        <option value="0">Nee</option>
                    </x-ccm::forms.select>

                    @if ($fileType === 'csv')
                        <x-ccm::forms.select wire:model.live="config.delimiter" label="Veldwaardes gescheiden door">
                            <option value=";">Puntkomma</option>
                            <option value=",">Komma</option>
                            <option value="\t">Tab</option>
                            <option value="|">Pipe</option>
                        </x-ccm::forms.select>
                        <x-ccm::forms.select wire:model.live="config.enclosure" label="Tekst ingesloten door">
                            <option value="">Geen</option>
                            <option value="dq">Dubbele quotes</option>
                            <option value="q">Enkele quote</option>
                        </x-ccm::forms.select>
                        <x-ccm::forms.input wire:model.live="config.escape_character">
                            Insluitingsteken ontsnapt door
                        </x-ccm::forms.input>
                    @endif
                @endif

            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1" :no-margin="true">
                <x-ccm::tables.table>
                    <x-slot:thead>
                        @foreach ($rows AS $key => $row)
                            <x-ccm::tables.th>{{ $row['key'] }}</x-ccm::tables.th>
                        @endforeach
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($sheet AS $key => $row)
                            <x-ccm::tables.tr>
                                @foreach ($row AS $field)
                                    <x-ccm::tables.td>{{ $field }}</x-ccm::tables.td>
                                @endforeach
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                </x-ccm::tables.table>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2" :no-margin="true">
                <div class="flex gap-4 bg-gray-200">
                    <div class="w-1/3 p-2">Veldnaam in bestand</div>
                    <div class="w-1/3 p-2">Importeren in CRM-veld</div>
                    <div class="w-1/6 p-2">Koppelen<br>voor ontdubbeling</div>
                    <div class="w-1/6 p-2">Overschrijven<br>met lege waarde</div>
                    <div class="w-1/6 p-2">Niet overschrijven<br>indien gevuld</div>
                </div>
                <div class="flex flex-col divide-y">
                    @foreach ($rows AS $key => $row)
                        <div class="flex gap-4 py-2 items-center {{ $rows[$key]['crm_field_id'] ? 'bg-green-50' : 'bg-red-50' }}">
                            <div class="w-1/3 pl-2">{{ $row['key'] }}</div>
                            <div class="w-1/3">
                                <x-ccm::forms.select wire:model.live="rows.{{ $key }}.crm_field_id">
                                    <option value="0">Niet importeren</option>
                                    <option value="crm_id">CRM ID</option>
                                    <x-ccm::forms.crm-fields-options/>
                                </x-ccm::forms.select>
                            </div>
                            @if ($rows[$key]['crm_field_id'] > 0)
                                <div class="w-1/6">
                                    @if (
                                        $rows[$key]['crm_field_id'] === 'crm_id' ||
                                        \Sellvation\CCMV2\CrmCards\Models\CrmField::find($rows[$key]['crm_field_id'])?->is_shown_on_target_group_builder
                                    )
                                        <x-ccm::forms.checkbox
                                                wire:model="rows.{{ $key }}.attach_to_crm_card"></x-ccm::forms.checkbox>
                                    @endif
                                </div>
                                <div class="w-1/6">
                                    <x-ccm::forms.checkbox
                                            wire:model="rows.{{ $key }}.overwrite_empty"></x-ccm::forms.checkbox>
                                </div>
                                <div class="w-1/6">
                                    <x-ccm::forms.checkbox
                                            wire:model="rows.{{ $key }}.overwrite_filled"></x-ccm::forms.checkbox>
                                </div>
                            @else
                                <div class="w-1/6">&nbsp;</div>
                                <div class="w-1/6">&nbsp;</div>
                                <div class="w-1/6">&nbsp;</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
    <x-ccm::layouts.modal>
        <x-slot:title>Importeren</x-slot:title>
        De import wordt gestart, dit kan enkele minuten duren
        <x-slot:buttons></x-slot:buttons>
    </x-ccm::layouts.modal>
</div>
