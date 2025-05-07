<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Server wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::servers::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Gegevens</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form>
                    <x-ccm::forms.input name="form.name" wire:model="form.name" :required="true">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.type" wire:model="form.type" label="Soort server" :required="true">
                        <option></option>
                        <option value="app">App</option>
                        <option value="api">Api</option>
                        <option value="db">Database</option>
                        <option value="redis">Redis</option>
                        <option value="worker">Worker</option>
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.ip" wire:model="form.ip" :required="true">
                        IP-adres
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.status_url" wire:model="form.status_url">
                        Status URL
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
