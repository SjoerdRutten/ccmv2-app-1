<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Mailserver wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::mailservers::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.host"
                                        wire:model="form.host"
                                        :required="true"
                    >
                        Host
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.private_ip"
                                        wire:model="form.private_ip"
                                        :required="true"
                    >
                        Private IP
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description"
                                        wire:model="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.checkbox name="form.is_active"
                                           wire:model="form.is_active">
                        Actief
                    </x-ccm::forms.checkbox>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
