<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Pagina wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::pages::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.name"
                                        wire:model.blur="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.slug"
                                        wire:model.blur="form.slug"
                                        :required="true"
                    >
                        Slug
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.site_layout_id"
                                         wire:model="form.site_layout_id"
                                         :required="true"
                                         label="Layout"
                    >
                        <option></option>
                        @foreach ($siteLayouts AS $siteLayout)
                            <option value="{{ $siteLayout->id }}">
                                {{ $siteLayout->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.description"
                                        wire:model="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
