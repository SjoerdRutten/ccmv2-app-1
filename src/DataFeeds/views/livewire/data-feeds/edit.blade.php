<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Data feed">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('df::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>

                @if ($dataFeed->id > 0)
                    <x-ccm::tabs.nav-tab :index="1">Velden</x-ccm::tabs.nav-tab>
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
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
