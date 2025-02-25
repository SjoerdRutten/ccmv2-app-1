<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8" x-data="stripo({
        token: @entangle('stripoToken'),
        html: @entangle('form.html'),
        stripoHtml: @entangle('form.stripo_html'),
        stripoCss: @entangle('form.stripo_css'),
        emailId: @entangle('form.email_id'),
    })">
        <x-ccm::pages.intro title="E-mail wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('ems::emails::overview')">Terug</x-ccm::buttons.back>
                @if ($email->html_type === 'STRIPO')
                    <x-ccm::buttons.save x-on:click="saveStripo"></x-ccm::buttons.save>
                @else
                    <x-ccm::buttons.save wire:click="save" id="btnSave"></x-ccm::buttons.save>
                @endif
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                @if ($email->id)
                    @if ($this->form->html_type === 'STRIPO')
                        <x-ccm::tabs.nav-tab :index="3">E-mail editor</x-ccm::tabs.nav-tab>
                    @else
                        <x-ccm::tabs.nav-tab :index="1">Inhoud HTML-deel</x-ccm::tabs.nav-tab>
                    @endif
                    <x-ccm::tabs.nav-tab :index="2">Inhoud Tekst-deel</x-ccm::tabs.nav-tab>
                    <x-ccm::tabs.nav-tab :index="4">Preview</x-ccm::tabs.nav-tab>
                @endif
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.name" wire:model.live="form.name">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.email_category_id"
                            wire:model.live="form.email_category_id"
                            label="Rubriek"
                    >
                        <option></option>
                        @foreach ($form->categories() AS $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.description" wire:model.live="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.sender_email" wire:model.live="form.sender_email">
                        Afzender e-mail
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.sender_name" wire:model.live="form.sender_name">
                        Afzender naam
                    </x-ccm::forms.input>
                    <div class="flex gap-4">
                        <x-ccm::forms.select
                                name="form.recipient_type"
                                wire:model.live="form.recipient_type"
                                label="Ontvanger type"
                        >
                            <option value="CRMFIELD">CRM Veld</option>
                            <option value="TEXT">Tekstveld</option>
                        </x-ccm::forms.select>
                        @if ($this->form->recipient_type === 'CRMFIELD')
                            <x-ccm::forms.select
                                    name="form.recipient_crm_field_id"
                                    wire:model.live="form.recipient_crm_field_id"
                                    label="CRM Veld"
                                    :grow="true"
                            >
                                <option></option>
                                @foreach ($form->emailFields() AS $field)
                                    <option value="{{ $field->id }}">
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </x-ccm::forms.select>
                        @else
                            <x-ccm::forms.input name="form.recipient"
                                                wire:model.live="form.recipient"
                                                :grow="true">
                                Ontvanger
                            </x-ccm::forms.input>
                        @endif
                    </div>
                    <x-ccm::forms.input name="form.reply_to" wire:model.live="form.reply_to">
                        Reply to
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.subject" wire:model.live="form.subject">
                        Onderwerp
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.optout_url" wire:model.live="form.optout_url">
                        Uitschrijflink
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.html_type"
                            wire:model.live="form.html_type"
                            label="HTML Editor"
                            :disabled="$this->form->id > 0"
                    >
                        <option value="HTML">HTML Editor</option>
                        <option value="STRIPO">Stripo</option>
                        {{--                        <option value="WYSIWYG EDITOR">Wysiwyg editor</option>--}}
                    </x-ccm::forms.select>
                </div>
            </x-ccm::tabs.tab-content>
            @if ($email->id)
                <x-ccm::tabs.tab-content :index="1">
                    {{--                <x-ccm::forms.html-editor wire-name="form.html"/>--}}
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="2">
                    <x-ccm::forms.textarea name="text" wire:model="form.text" rows="30"></x-ccm::forms.textarea>
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="3" :no-margin="true">
                    <div class="notification-zone"></div>
                    <div class="flex">
                        <!--Plugin containers -->
                        <div id="stripoSettingsContainer" class="w-1/4">Loading...</div>
                        <div id="stripoPreviewContainer" class="w-3/4"></div>
                    </div>
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="4">
                    <div class="mb-4">
                        <x-ccm::forms.input wire:model.live="crmId">Crm ID</x-ccm::forms.input>
                    </div>

                    <iframe src="{{ route('ems::emails::preview', ['email' => $email, 'crmCard' => $crmCard, 'crc' => $crc]) }}"
                            class="w-full h-[800px]"></iframe>
                </x-ccm::tabs.tab-content>
            @endif
        </x-ccm::tabs.base>
    </div>
</div>
@once
    @push('js')
        @if (app()->environment('local'))
            <script defer src="/vendor/ccm/js/alpinejs-stripo.js"></script>
        @else
            <script defer src="/vendor/ccm/js/alpinejs-stripo.min.js"></script>
        @endif
    @endpush
@endonce