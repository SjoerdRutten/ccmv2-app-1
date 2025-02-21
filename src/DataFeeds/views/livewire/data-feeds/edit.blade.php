<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Data feed">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::data_feeds::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>

                @if ($dataFeed->id > 0)
                    <x-ccm::tabs.nav-tab :index="1">Velden</x-ccm::tabs.nav-tab>

                    @if ($form->data_config['reference_key'])
                        <x-ccm::tabs.nav-tab :index="2">Data</x-ccm::tabs.nav-tab>
                    @endif
                @endif
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.name" wire:model="form.name" :required="true">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description" wire:model="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.type" wire:model.live="form.type"
                                         label="Gegevensbron benaderen met"
                                         :required="true"
                    >
                        <option></option>
                        @foreach ($types AS $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.checkbox name="form.is_active" wire:model="form.is_active">
                        Actief
                    </x-ccm::forms.checkbox>

                    @if ($form->type === 'https')
                        <x-ccm::forms.input name="form.feed_config.url" wire:model="form.feed_config.url"
                                            :required="true">
                            URL
                        </x-ccm::forms.input>
                        <x-ccm::forms.input name="form.feed_config.username" wire:model="form.feed_config.username">
                            Gebruikersnaam
                        </x-ccm::forms.input>
                        <x-ccm::forms.input name="form.feed_config.password" wire:model="form.feed_config.password">
                            Wachtwoord
                        </x-ccm::forms.input>
                    @elseif ($form->type === 'ftps')
                        FTPS
                    @elseif ($form->type === 'scp')
                        SCP
                    @elseif ($form->type === 'sftp')
                        SFTP
                    @elseif ($form->type === 'sql')
                        SQL
                    @endif

                    @if (!empty($form->type) && $form->type !== 'sql')
                        <x-ccm::forms.select name="form.feed_config.content_type"
                                             wire:model.live="form.feed_config.content_type"
                                             label="File soort"
                                             :required="true"
                        >
                            <option></option>
                            <option value="xml">XML</option>
                            <option value="csv">CSV</option>
                            <option value="json">JSON</option>
                        </x-ccm::forms.select>
                    @endif
                    @if (Arr::get($form->feed_config, 'content_type') === 'csv')
                        <x-ccm::typography.h2>CSV Instellingen</x-ccm::typography.h2>
                        <x-ccm::forms.select name="form.feed_config.header_row"
                                             wire:model.live="form.feed_config.header_row"
                                             label="Veldnaam op regel 1"
                        >
                            <option value="0">Nee</option>
                            <option value="1">Ja</option>
                        </x-ccm::forms.select>
                        <x-ccm::forms.select name="form.feed_config.seperator"
                                             wire:model.live="form.feed_config.seperator"
                                             label="Velden beëindigd door"
                        >
                            <option value="comma">Komma</option>
                            <option value="semicolon">Puntkomma</option>
                            <option value="tab">Tab</option>
                            <option value="pipe">Pipe</option>
                        </x-ccm::forms.select>
                        <x-ccm::forms.select name="form.feed_config.enclosure"
                                             wire:model.live="form.feed_config.enclosure"
                                             label="Tekst ingesloten door"
                        >
                            <option value="">Geen</option>
                            <option value="quotes">Enkele quote</option>
                            <option value="double_quotes">Dubbele quotes</option>
                        </x-ccm::forms.select>
                        <x-ccm::forms.input name="form.feed_config.escape" wire:model="form.feed_config.escape">
                            Insluitingsteken ontsnapt door
                        </x-ccm::forms.input>
                    @endif
                </div>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.select name="form.data_config.reference_key"
                                     wire:model.live="form.data_config.reference_key"
                                     label="Referentie key">
                    <option></option>
                    @foreach ($form->data_config['fields'] AS $key => $value)
                        <option>{{ $key }}</option>
                    @endforeach
                </x-ccm::forms.select>


                <x-ccm::typography.h2 class="mt-5">Veldnamen aanpassen</x-ccm::typography.h2>
                @foreach ($form->data_config["fields"] AS $key => $value)
                    <div class="flex gap-4 items-center hover:bg-gray-100 p-1">
                        <x-ccm::forms.checkbox name="form.data_config.fields.{{ $key }}.visible"
                                               wire:model="form.data_config.fields.{{ $key }}.visible"/>

                        <div class="w-1/5">
                            {{ $key }}
                        </div>
                        <div class="w-1/5">
                            <x-ccm::forms.input name="form.data_config.fields.{{ $key }}.label"
                                                wire:model="form.data_config.fields.{{ $key }}.label">
                            </x-ccm::forms.input>
                        </div>
                        <div class="truncate w-1/2">
                            {{ datafeed(1, null, $value['label'] ?? $value['key']) }}
                        </div>
                    </div>
                @endforeach
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::forms.select name="reference" wire:model.live="reference"
                                     label="Referentie">
                    <option></option>
                    @foreach ($references AS $key => $value)
                        <option>{{ $value }}</option>
                    @endforeach
                </x-ccm::forms.select>

                <x-ccm::tables.table>
                    <x-slot:thead>
                        <x-ccm::tables.th>Key</x-ccm::tables.th>
                        <x-ccm::tables.th>Value</x-ccm::tables.th>
                        <x-ccm::tables.th>Helper</x-ccm::tables.th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($form->data_config["fields"] AS $key => $value)
                            <x-ccm::tables.tr>
                                <x-ccm::tables.th>{{ $key }}</x-ccm::tables.th>
                                <x-ccm::tables.td>
                                    {{ \Illuminate\Support\Str::substr(datafeed($dataFeed->id, $reference, $value['label'] ?? $value['key']), 0, 80) }}
                                </x-ccm::tables.td>
                                <x-ccm::tables.td>datafeed({{ $dataFeed->id }}, '{{ $reference }}',
                                    '{{ $value['label'] ?? $value['key'] }}')
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                </x-ccm::tables.table>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
