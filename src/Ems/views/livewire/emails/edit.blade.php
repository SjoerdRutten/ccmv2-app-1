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
                @if ($email->is_locked)
                    <x-ccm::buttons.success wire:click="unlock"
                                            wire:confirm="Weet je zeker dat je deze mail wilt ontgrendelen?"
                                            icon="heroicon-c-lock-open">
                        Ontgrendelen
                    </x-ccm::buttons.success>
                @else
                    <x-ccm::buttons.warning wire:click="lock"
                                            wire:confirm="Weet je zeker dat je deze mail wilt vergrendelen?"
                                            icon="heroicon-c-lock-closed">
                        Vergrendelen
                    </x-ccm::buttons.warning>

                    @if ($email->html_type === \Sellvation\CCMV2\Ems\Models\Email::STRIPO)
                        <x-ccm::buttons.save x-on:click="saveStripo"></x-ccm::buttons.save>
                    @else
                        <x-ccm::buttons.save wire:click="save" id="btnSave"></x-ccm::buttons.save>
                    @endif
                @endif
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="5">Mail informatie</x-ccm::tabs.nav-tab>
                @if ($email->id)
                    @if ($this->form->html_type === \Sellvation\CCMV2\Ems\Models\Email::STRIPO)
                        <x-ccm::tabs.nav-tab :index="3">E-mail editor</x-ccm::tabs.nav-tab>
                    @else
                        <x-ccm::tabs.nav-tab :index="1">Inhoud HTML-deel</x-ccm::tabs.nav-tab>
                    @endif
                    <x-ccm::tabs.nav-tab :index="2">Inhoud Tekst-deel</x-ccm::tabs.nav-tab>
                    <x-ccm::tabs.nav-tab :index="4">Preview</x-ccm::tabs.nav-tab>
                    <x-ccm::tabs.nav-tab :index="6">Links</x-ccm::tabs.nav-tab>
                @endif
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.name" wire:model="form.name" :required="true">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.type"
                            wire:model.live="form.type"
                            label="Mail type"
                            :required="true"
                    >
                        <option></option>
                        <option value="{{ \Sellvation\CCMV2\Ems\Enums\EmailType::TRANSACTIONAL }}">{{ \Sellvation\CCMV2\Ems\Enums\EmailType::TRANSACTIONAL->name() }}</option>
                        <option value="{{ \Sellvation\CCMV2\Ems\Enums\EmailType::MARKETING }}">{{ \Sellvation\CCMV2\Ems\Enums\EmailType::MARKETING->name() }}</option>
                        <option value="{{ \Sellvation\CCMV2\Ems\Enums\EmailType::SERVICE }}">{{ \Sellvation\CCMV2\Ems\Enums\EmailType::SERVICE->name() }}</option>
                    </x-ccm::forms.select>
                    <x-ccm::forms.select
                            name="form.email_category_id"
                            wire:model="form.email_category_id"
                            label="Rubriek"
                    >
                        <option></option>
                        @foreach ($form->categories() AS $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.description" wire:model="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.site_id"
                            wire:model="form.site_id"
                            label="Tracking domein"
                            :required="true"
                    >
                        <option></option>
                        @foreach ($sites AS $site)
                            <option value="{{ $site->id }}">
                                {{ $site->domain }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input
                            name="form.utm_code"
                            wire:model="form.utm_code"
                    >Toevoegen aan tracking links (zonder ?)
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.html_type"
                            wire:model="form.html_type"
                            label="HTML Editor"
                            :disabled="$this->form->id > 0"
                    >
                        <option></option>
                        <option value="{{ \Sellvation\CCMV2\Ems\Models\Email::HTML }}">HTML Editor</option>
                        <option value="{{ \Sellvation\CCMV2\Ems\Models\Email::STRIPO }}">Stripo</option>
                    </x-ccm::forms.select>
                </div>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="5">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.sender_email" wire:model="form.sender_email" :required="true">
                        Afzender e-mail
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.sender_name" wire:model="form.sender_name">
                        Afzender naam
                    </x-ccm::forms.input>
                    <div class="flex gap-4">
                        <x-ccm::forms.select
                                name="form.recipient_type"
                                wire:model="form.recipient_type"
                                label="Ontvanger type"
                        >
                            <option value="CRMFIELD">CRM Veld</option>
                            <option value="TEXT">Tekstveld</option>
                        </x-ccm::forms.select>
                        @if ($this->form->recipient_type === 'CRMFIELD')
                            <x-ccm::forms.select
                                    name="form.recipient_crm_field_id"
                                    wire:model="form.recipient_crm_field_id"
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
                                                wire:model="form.recipient"
                                                :grow="true">
                                Ontvanger
                            </x-ccm::forms.input>
                        @endif
                    </div>
                    <x-ccm::forms.input name="form.reply_to" wire:model="form.reply_to">
                        Reply to
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.subject" wire:model="form.subject">
                        Onderwerp
                    </x-ccm::forms.input>
                    <x-ccm::forms.textarea name="form.pre_header" wire:model="form.pre_header">
                        Pre-header
                    </x-ccm::forms.textarea>
                    <x-ccm::forms.input name="form.optout_url" wire:model="form.optout_url">
                        Uitschrijflink
                    </x-ccm::forms.input>

                </div>
            </x-ccm::tabs.tab-content>
            @if ($email->id)
                <x-ccm::tabs.tab-content :index="6" :no-margin="true">
                    <x-ccm::tables.table>
                        <x-slot:thead>
                            <x-ccm::tables.th>Link</x-ccm::tables.th>
                            <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                            <x-ccm::tables.th>Aantal links</x-ccm::tables.th>
                            <x-ccm::tables.th>Aantal clicks</x-ccm::tables.th>
                        </x-slot:thead>
                        <x-slot:tbody>
                            @foreach ($email->trackableLinks AS $link)
                                <x-ccm::tables.tr>
                                    <x-ccm::tables.td :first="true"
                                                      class="truncate">{{ $link->link }}</x-ccm::tables.td>
                                    <x-ccm::tables.td>{{ $link->text }}</x-ccm::tables.td>
                                    <x-ccm::tables.td>{{ $link->count }}</x-ccm::tables.td>
                                    <x-ccm::tables.td>{{ $link->trackableLinkClicks()->count() }}</x-ccm::tables.td>
                                </x-ccm::tables.tr>
                            @endforeach
                        </x-slot:tbody>
                    </x-ccm::tables.table>
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="1">
                    <x-ccm::forms.html-editor wire-name="form.html"/>
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="2">
                    <x-ccm::forms.textarea name="text" wire:model="form.text" rows="30"></x-ccm::forms.textarea>
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="3" :no-margin="true">
                    <div class="notification-zone"></div>
                    <div class="flex" wire:ignore>
                        <!--Plugin containers -->
                        <div id="stripoSettingsContainer" class="w-1/4">Loading...</div>
                        <div id="stripoPreviewContainer" class="w-3/4"></div>
                    </div>
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="4">
                    <div class="mb-4 gap-2 grid grid-cols-4 items-end">
                        <x-ccm::forms.input wire:model="crmId">
                            Crm ID
                        </x-ccm::forms.input>
                        <x-ccm::forms.input type="email" wire:model="testEmailAddress">
                            Test verzenden aan
                        </x-ccm::forms.input>
                        <div>
                            <x-ccm::buttons.success wire:click="sendTestEmail">
                                Test mail verzenden
                            </x-ccm::buttons.success>
                        </div>
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