<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Contentblok wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::blocks::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Body</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.name"
                                        wire:model.blur="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description"
                                        wire:model="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.form_id"
                                         wire:model="form.form_id"
                                         label="Formulier">
                        <option></option>
                        @foreach ($forms AS $form)
                            <option value="{{ $form->id }}">
                                {{ $form->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input-datetime name="form.start_at"
                                                 wire:model="form.start_at">
                        Begin publicatie
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.input-datetime name="form.end_at"
                                                 wire:model="form.end_at">
                        Einde publicatie
                    </x-ccm::forms.input-datetime>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <div class="grid grid-cols-5 gap-4">
                    <x-ccm::forms.html-editor wire-name="form.body" class="col-span-4"></x-ccm::forms.html-editor>
                    <div>
                        <x-ccm::typography.h2>Beschikbare variabelen</x-ccm::typography.h2>
                        <dl>
                            @foreach ($availableVariables AS $key => $description)
                                <dt class="font-bold">${{ $key }}</dt>
                                <dd class="border-b text-sm">{{ $description }}</dd>
                            @endforeach
                        </dl>
                    </div>
                </div>

            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
