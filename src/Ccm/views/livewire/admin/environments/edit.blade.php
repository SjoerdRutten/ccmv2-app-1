<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Omgeving wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::environments')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Gegevens</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form>
                    <x-ccm::forms.select label="Klant" wire:model="form.customer_id">
                        <option></option>
                        @foreach ($this->form->getCustomers() AS $key => $name)
                            <option value="{{ $key }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.select label="Tijdzone" wire:model="form.timezone_id">
                        @foreach ($this->form->getTimezones() AS $key => $name)
                            <option value="{{ $key }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>

                    <x-ccm::forms.input name="form.name" wire:model="form.name" maxlength="40">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description" wire:model="form.description" maxlength="80">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input type="number" name="form.email_credits" wire:model="form.email_credits"
                                        step="1">
                        E-mail credits
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
