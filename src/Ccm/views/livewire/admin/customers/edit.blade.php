<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Klant wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::customers')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Gegevens</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Firewall</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form>
                    <x-ccm::forms.input name="form.name" wire:model.live="form.name">Naam</x-ccm::forms.input>
                    <x-ccm::forms.input name="form.telephone" wire:model="form.telephone">Telefoonnummer
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.fax" wire:model="form.fax">Fax</x-ccm::forms.input>
                    <x-ccm::forms.input name="form.email" wire:model="form.email">E-mail</x-ccm::forms.input>
                    <x-ccm::forms.input name="form.url" wire:model="form.url">URL</x-ccm::forms.input>
                    <x-ccm::forms.input name="form.logo" wire:model="form.logo">Logo</x-ccm::forms.input>

                    <div class="border border-gray-200 rounded p-4 mt-2">
                        <h2>Bezoekadres</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <x-ccm::forms.input name="form.visiting_address" wire:model="form.visiting_address">
                                Adres
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.visiting_address_postcode"
                                                wire:model="form.visiting_address_postcode">
                                Postcode
                            </x-ccm::forms.input>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <x-ccm::forms.input name="form.visiting_address_city"
                                                wire:model="form.visiting_address_city">
                                Plaats
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.visiting_address_state"
                                                wire:model="form.visiting_address_state">
                                Provincie
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.visiting_address_country"
                                                wire:model="form.visiting_address_country">
                                Land
                            </x-ccm::forms.input>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded p-4 mt-2">
                        <h2>Postadres</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <x-ccm::forms.input name="form.visiting_address" wire:model="form.post_address">
                                Adres
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.post_address_postcode"
                                                wire:model="form.post_address_postcode">
                                Postcode
                            </x-ccm::forms.input>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <x-ccm::forms.input name="form.post_address_city" wire:model="form.post_address_city">
                                Plaats
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.post_address_state" wire:model="form.post_address_state">
                                Provincie
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.post_address_country" wire:model="form.post_address_country">
                                Land
                            </x-ccm::forms.input>
                        </div>
                    </div>

                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.textarea name="form.allowed_ips" wire:model="form.allowed_ips" rows="20">
                    Toegestane ip-adressen (1 per regel)
                </x-ccm::forms.textarea>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
