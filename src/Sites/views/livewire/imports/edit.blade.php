<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="JS/CSS wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::imports::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                @if ($siteImport->id)
                    <x-ccm::tabs.nav-tab :index="1">Body</x-ccm::tabs.nav-tab>
                @endif
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">

                    <x-ccm::forms.select label="Soort"
                                         wire:model.live="form.type"
                                         :disabled="!!$siteImport->id"
                    >
                        <option></option>
                        <option value="js">Javascript</option>
                        <option value="css">Stylesheet</option>
                    </x-ccm::forms.select>
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
            @if ($siteImport->id)
                <x-ccm::tabs.tab-content :index="1">
                    <x-ccm::forms.html-editor wire-name="form.body"
                                              :type="$siteImport->type"></x-ccm::forms.html-editor>
                </x-ccm::tabs.tab-content>
            @endif
        </x-ccm::tabs.base>
    </div>
</div>
