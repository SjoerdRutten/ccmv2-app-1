<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM Kaart wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('crm-cards::cards::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::accordion.base>
            <x-ccm::accordion.row title="Algemeen" key="0">
                <x-ccm::description-lists.base title="Basisgegevens">
                    <x-ccm::description-lists.element label="CrmID">{{ $crmCard->crm_id }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Laatste IP">{{ $crmCard->latest_ip }}</x-ccm::description-lists.element>
                </x-ccm::description-lists.base>
                <x-ccm::description-lists.base title="Statistieken">
                    <x-ccm::description-lists.element label="Datum creatie">{{ $crmCard->created_at->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Datum mutatie">{{ $crmCard->updated_at->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Eerste bezoek">{{ $crmCard->first_visit_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Laatste bezoek">{{ $crmCard->latest_visit_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Eerste e-mail">{{ $crmCard->first_email_send_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Laatste e-mail">{{ $crmCard->latest_email_send_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Eerste e-mail geopend">{{ $crmCard->first_email_opened_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Laatste e-mail geopend">{{ $crmCard->latest_email_opened_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Eerste e-mail geklikt">{{ $crmCard->first_email_clicked_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Laatste e-mail geklikt">{{ $crmCard->latest_email_clicked_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                </x-ccm::description-lists.base>
                <x-ccm::description-lists.base title="Browser gegevens">
                    <x-ccm::description-lists.element label="Browser">{{ $crmCard->browser }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="OS">{{ $crmCard->browser_os }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Devicetype">{{ $crmCard->browser_device_type }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Device">{{ $crmCard->browser_device }}</x-ccm::description-lists.element>
                </x-ccm::description-lists.base>
                <x-ccm::description-lists.base title="Mail client gegevens">
                    <x-ccm::description-lists.element label="Mailclient">{{ $crmCard->mailclient }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="OS">{{ $crmCard->mailclient_os }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Devicetype">{{ $crmCard->mailclient_device_type }}</x-ccm::description-lists.element>
                    <x-ccm::description-lists.element label="Device">{{ $crmCard->mailclient_device }}</x-ccm::description-lists.element>
                </x-ccm::description-lists.base>
            </x-ccm::accordion.row>
            @foreach ($this->form->categories() AS $key => $category)
                <x-ccm::accordion.row :title="$category->name" :key="$key + 1">
                    <x-ccm::description-lists.base title="">
                        
                        @foreach ($category->crmFields AS $crmField)
                            @if ($crmField->type === 'MEDIA')
                                <h2 class="col-span-full font-bold">{{ $crmField->label ?: $crmField->name }}</h2>
                                <div class="border border-gray-800 col-span-full grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded">
                                    <x-ccm::description-lists.element label="Optin">
                                        <x-ccm::forms.checkbox :name="$crmField.'_optin'" wire:model.live="form.data._{{ $crmField->name }}_optin" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Optin timestamp">
                                        <x-ccm::forms.input type="datetime-local" :name="$crmField.'_optin_timestamp'" wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin_timestamp" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Confirmed optin">
                                        <x-ccm::forms.checkbox :name="$crmField.'_confirmed_optin'" wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Confirmed optin timestamp">
                                        <x-ccm::forms.input type="datetime-local" :name="$crmField.'_confirmed_optin_timestamp'" wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin_timestamp" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Optout">
                                        <x-ccm::forms.checkbox :name="$crmField.'_confirmed_optout'" wire:model.live="form.data._{{ $crmField->name }}_confirmed_optout" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Optout timestamp">
                                        <x-ccm::forms.input type="datetime-local" :name="$crmField.'_optout_timestamp'" wire:model.live="form.data._{{ $crmField->name }}_optout_timestamp" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                </div>
                            @elseif ($crmField->type === 'EMAIL')
                                <h2 class="col-span-full font-bold">{{ $crmField->label ?: $crmField->name }}</h2>
                                <div class="border border-gray-800 col-span-full grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded">
                                    <x-ccm::description-lists.element label="E-mail" class="col-span-full">
                                        <x-ccm::forms.input :name="$crmField" wire:model.live="form.data.{{ $crmField->name }}" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Abuse">
                                        <x-ccm::forms.checkbox :name="$crmField.'_abuse'" wire:model.live="form.data._{{ $crmField->name }}_abuse" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Abuse timestamp">
                                        <x-ccm::forms.input type="datetime-local" :name="$crmField.'_abuse_timestamp'" wire:model.live="form.data._{{ $crmField->name }}_abuse_timestamp" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Bounce reden">
                                        <x-ccm::forms.input :name="$crmField.'_bounce_reason'" wire:model.live="form.data._{{ $crmField->name }}_bounce_reason" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Bounce score">
                                        <x-ccm::forms.input type="number" :name="$crmField.'_bounce_score'" wire:model.live="form.data._{{ $crmField->name }}_bounce_score" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Bounce type">
                                        <x-ccm::forms.input :name="$crmField.'_bounce_type'" wire:model.live="form.data._{{ $crmField->name }}_bounce_type" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                    <x-ccm::description-lists.element label="Email type">
                                        <x-ccm::forms.input :name="$crmField.'_type'" wire:model.live="form.data._{{ $crmField->name }}_type" :disabled="true" />
                                    </x-ccm::description-lists.element>
                                </div>
                            @else
                                <x-ccm::description-lists.element :label="$crmField->label ?: $crmField->name" :title="$crmField->name">
                                    @if ($crmField->type === 'TEXTMICRO')
                                        <x-ccm::forms.input maxlength="4" :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'TEXTMINI')
                                        <x-ccm::forms.input maxlength="10" :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'TEXTSMALL')
                                        <x-ccm::forms.input maxlength="10" :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'TEXTMIDDLE')
                                        <x-ccm::forms.input maxlength="80" :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'TEXTBIG')
                                        <x-ccm::forms.textarea :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'INT')
                                        <x-ccm::forms.input type="number" step="1" :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'DECIMAL')
                                        <x-ccm::forms.input type="number" step="0.01" :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'DATETIME')
                                        <x-ccm::forms.input type="datetime-local" :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif (($crmField->type === 'CONSENT') || ($crmField->type === 'BOOLEAN'))
                                        <x-ccm::forms.checkbox :name="$crmField" wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked" />
                                    @elseif ($crmField->type === 'BESTAND')
                                        TODO: Fieldtype BESTAND
                                    @endif
                                </x-ccm::description-lists.element>
                            @endif
                        @endforeach
                    </x-ccm::description-lists.base>
                </x-ccm::accordion.row>
            @endforeach
        </x-ccm::accordion.base>
    </div>
</div>
