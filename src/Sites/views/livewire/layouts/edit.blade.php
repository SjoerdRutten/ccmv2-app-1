<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Layout wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::layouts::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Meta informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Body</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.name"
                                        wire:model="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description"
                                        wire:model="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.meta_title"
                                        wire:model="form.meta_title"
                    >
                        Meta title (max. 64 karakters)
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.meta_description"
                                        wire:model="form.meta_description"
                    >
                        Meta description (max. 150 karakters)
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.meta_keywords"
                                        wire:model="form.meta_keywords"
                    >
                        Meta keywords
                    </x-ccm::forms.input>
                    <x-ccm::forms.checkbox name="form.follow" wire:model="form.follow">
                        Follow
                    </x-ccm::forms.checkbox>
                    <x-ccm::forms.checkbox name="form.index" wire:model="form.index">
                        Index
                    </x-ccm::forms.checkbox>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::forms.html-editor wire-name="form.body"></x-ccm::forms.html-editor>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
