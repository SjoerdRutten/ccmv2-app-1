<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail domein">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::email_domains::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">DKIM</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.domain" wire:model.live="form.domain">
                        Domeinnaam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description" wire:model.live="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.return_path" wire:model.live="form.return_path">
                        Return-path ('envelope sender') aligned met domeinnaam
                        (i.p.v. systeemwaarde@ccmprofessional.com)
                    </x-ccm::forms.input>
                </div>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.dkim_selector_prefix" wire:model.live="form.dkim_selector_prefix">
                        Selector prefix
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.dkim_expires_at" wire:model.live="form.dkim_expires_at"
                                        :disabled="true">
                        Verloopt op
                    </x-ccm::forms.input>
                    <x-ccm::forms.textarea name="form.dkim_private_key"
                                           wire:model.live="form.dkim_private_key"
                                           :disabled="true"
                                           rows="10"
                    >
                        Private key
                    </x-ccm::forms.textarea>
                    <x-ccm::forms.textarea name="form.dkim_public_key"
                                           wire:model.live="form.dkim_public_key"
                                           :disabled="true"
                                           rows="10"
                    >
                        Public key
                    </x-ccm::forms.textarea>
                    <x-ccm::forms.input name="dkimKey"
                                        value="{{ $this->getDnsRecordKey() }}"
                                        :disabled="true">
                        DNS Record key
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="dkim"
                                        value="{{ $this->getDnsRecordValue() }}"
                                        :disabled="true">
                        DNS Record value
                    </x-ccm::forms.input>


                    <x-ccm::buttons.primary wire:click="generateDkim">Genereer DKIM</x-ccm::buttons.primary>
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
