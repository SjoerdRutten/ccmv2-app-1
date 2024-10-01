<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM Veld wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Veld</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Kenmerken</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Validatie</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.input name="name" wire:model.live="form.name">Naam</x-ccm::forms.input>
                <x-ccm::forms.input name="name" wire:model="form.label">Omschrijving Nederlands</x-ccm::forms.input>
                <x-ccm::forms.input name="name" wire:model="form.label_en">Omschrijving Engels</x-ccm::forms.input>
                <x-ccm::forms.input name="name" wire:model="form.label_de">Omschrijving Duits</x-ccm::forms.input>
                <x-ccm::forms.input name="name" wire:model="form.label_fr">Omschrijving Frans</x-ccm::forms.input>
                <x-ccm::forms.select
                        wire:model="form.crm_field_category_id"
                        label="Rubriek"
                >
                    @foreach ($form->crmFieldCategories() AS $crmFieldCategory)
                        <option value="{{ $crmFieldCategory->id }}">
                            {{ $crmFieldCategory->name }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>
                <x-ccm::forms.select
                        wire:model="form.crm_field_type_id"
                        label="Type"
                        :disabled="!!$form->id"
                >
                    @foreach ($form->crmFieldTypes() AS $crmFieldType)
                        <option value="{{ $crmFieldType->id }}">
                            {{ $crmFieldType->name }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                Kenmerken
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                Validatie
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
