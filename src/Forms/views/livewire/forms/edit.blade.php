<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Formulier">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::forms::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">
                    Acties
                    <x-slot:badge>{{ count($editForm->async_actions) }}</x-slot:badge>
                </x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Inhoud HTML-deel</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="3">Testformulier</x-ccm::tabs.nav-tab>
                @if ($form->formResponses()->count())
                    <x-ccm::tabs.nav-tab :index="4">Form responses</x-ccm::tabs.nav-tab>
                @endif
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4 mb-4">
                    <x-ccm::forms.input name="editForm.name" wire:model="editForm.name">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="editForm.description" wire:model="editForm.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="editForm.success_redirect_action"
                                         wire:model.live="editForm.success_redirect_action"
                                         label="Redirect na verzenden formulier"
                    >
                        <option></option>
                        @foreach ($redirectActions AS $redirectAction)
                            <option value="{{ $redirectAction::class }}">
                                {{ $redirectAction->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    @if ($this->getRedirectActionForm())
                        {!! $this->getRedirectActionForm()->render() !!}
                    @endif
                </div>

                <x-ccm::typography.h2>Velden</x-ccm::typography.h2>

                <x-ccm::tables.table>
                    <x-slot:thead>
                        <x-ccm::tables.th>Crm veld</x-ccm::tables.th>
                        <x-ccm::tables.th>Label</x-ccm::tables.th>
                        <x-ccm::tables.th>Verplicht</x-ccm::tables.th>
                        <x-ccm::tables.th>Gekoppeld</x-ccm::tables.th>
                        <x-ccm::tables.th>CRM kaart aanmaken</x-ccm::tables.th>
                        <x-ccm::tables.th :link="true"></x-ccm::tables.th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($editForm->fields AS $key => $field)
                            <x-ccm::tables.tr>
                                <x-ccm::tables.td>
                                    <x-ccm::forms.select
                                            wire:model.live="editForm.fields.{{ $key }}.crm_field_id">
                                        <option></option>
                                        @foreach ($crmFields AS $crmField)
                                            <option value="{{ $crmField->id }}" data-type="{{ $crmField->type }}">
                                                {{ $crmField->name }} ({{ $crmField->type }})
                                            </option>
                                            @if ($crmField->type === 'MEDIA')
                                                <option value="{{ $crmField->id }}_optin">
                                                    {{ $crmField->name }} Opt-in
                                                </option>
                                            @endif
                                        @endforeach
                                    </x-ccm::forms.select>
                                </x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    <x-ccm::forms.input
                                            wire:model="editForm.fields.{{ $key }}.label"/>
                                </x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    <x-ccm::forms.checkbox
                                            wire:model.live="editForm.fields.{{ $key }}.required"></x-ccm::forms.checkbox>
                                </x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    @if ($field['required'])
                                        <x-ccm::forms.checkbox
                                                wire:model.live="editForm.fields.{{ $key }}.attach_to_crm_card"></x-ccm::forms.checkbox>
                                    @endif
                                </x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    @if ($field['required'] && $field['attach_to_crm_card'])
                                        <x-ccm::forms.checkbox
                                                wire:model.live="editForm.fields.{{ $key }}.create"></x-ccm::forms.checkbox>
                                    @endif
                                </x-ccm::tables.td>
                                <x-ccm::tables.td :link="true">
                                    <x-ccm::tables.delete-link
                                            wire:confirm="Weet je zeker dat je dit veld wilt verwijderen ?"
                                            wire:click="removeField('{{ $key }}')"></x-ccm::tables.delete-link>
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                </x-ccm::tables.table>

                <x-ccm::buttons.add wire:click="addField" class="mt-4">Veld toevoegen</x-ccm::buttons.add>

            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-slot:intro>
                    Hier kan je acties toevoegen die uitgevoerd worden op het moment dat een formulier goed is
                    gecorrigeerd en gevalideerd.
                    Deze acties worden in willekeurige volgorde op de achtergrond uitgevoerd.
                </x-slot:intro>

                @foreach ($editForm->async_actions AS $key => $action)
                    <x-ccm::layouts.block>
                        <x-ccm::forms.select wire:model.live="editForm.async_actions.{{ $key }}.action" label="Actie">
                            <option></option>
                            @foreach ($asyncActions AS $asyncAction)
                                <option value="{{ $asyncAction::class }}">
                                    {{ $asyncAction->name }}
                                </option>
                            @endforeach
                        </x-ccm::forms.select>
                        {!! $this->getAsyncForm($key) !!}
                    </x-ccm::layouts.block>
                @endforeach

                <x-slot:buttons>
                    <x-ccm::buttons.add wire:click="addAsyncAction" class="mt-4">Actie toevoegen</x-ccm::buttons.add>
                </x-slot:buttons>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::buttons.primary class="mb-4"
                                        wire:confirm="Weet je het zeker, het formulier wat er nu staat zal overschreven worden"
                                        wire:click.prevent="generateHtmlForm">
                    HTML Formulier genereren
                </x-ccm::buttons.primary>

                <x-ccm::forms.html-editor wire-name="editForm.html_form"/>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="3">
                {!! \Illuminate\Support\Facades\Blade::render($editForm->html_form) !!}
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="4">
                {!! \Illuminate\Support\Facades\Blade::render($editForm->html_form) !!}
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
