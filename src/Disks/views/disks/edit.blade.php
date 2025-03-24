<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Disk wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::disks::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Instellingen</x-ccm::tabs.nav-tab>
            </x-slot:tabs>
            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.name"
                                        wire:model="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.type" wire:model.live="form.type" :required="true"
                                         label="Soort verbinding">
                        <option></option>
                        <option value="ftp">FTP</option>
                    </x-ccm::forms.select>

                    <x-ccm::forms.input name="form.description"
                                        wire:model="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                @if ($form->type === 'ftp')
                    <x-ccm::forms.input name="form.settings.host"
                                        wire:model="form.settings.host"
                                        :required="true"
                    >
                        Host
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.settings.port"
                                        wire:model="form.settings.port"
                                        :required="true"
                    >
                        Port
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.settings.username"
                                        wire:model="form.settings.username"
                                        :required="true"
                    >
                        Username
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.settings.password"
                                        wire:model="form.settings.password"
                                        :required="true"
                    >
                        Username
                    </x-ccm::forms.input>
                @endif
            </x-ccm::tabs.tab-content>

        </x-ccm::tabs.base>
    </div>
</div>
