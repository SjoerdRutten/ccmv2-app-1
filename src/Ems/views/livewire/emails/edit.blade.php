<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('ems::emails::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Inhoud</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.name" wire:model.live="form.name">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.email_category_id"
                            wire:model.live="form.email_category_id"
                            label="Rubriek"
                    >
                        <option></option>
                        @foreach ($form->categories() AS $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.description" wire:model.live="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.sender_email" wire:model.live="form.sender_email">
                        Afzender e-mail
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.sender_name" wire:model.live="form.sender_name">
                        Afzender naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.recipient" wire:model.live="form.recipient">
                        Ontvanger
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.reply_to" wire:model.live="form.reply_to">
                        Reply to
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.subject" wire:model.live="form.subject">
                        Onderwerp
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.optout_url" wire:model.live="form.optout_url">
                        Uitschrijflink
                    </x-ccm::forms.input>
                </div>
                {{--                <x-ccm::forms.input name="form.label" wire:model.live="form.label">Omschrijving Nederlands--}}
                {{--                </x-ccm::forms.input>--}}
                {{--                <x-ccm::forms.input name="form.label_en" wire:model.live="form.label_en">Omschrijving Engels--}}
                {{--                </x-ccm::forms.input>--}}
                {{--                <x-ccm::forms.input name="form.label_de" wire:model.live="form.label_de">Omschrijving Duits--}}
                {{--                </x-ccm::forms.input>--}}
                {{--                <x-ccm::forms.input name="form.label_fr" wire:model.live="form.label_fr">Omschrijving Frans--}}
                {{--                </x-ccm::forms.input>--}}
                {{--                <x-ccm::forms.select--}}
                {{--                        name="form.crm_field_category_id"--}}
                {{--                        wire:model.live="form.crm_field_category_id"--}}
                {{--                        label="Rubriek"--}}
                {{--                >--}}
                {{--                    <option></option>--}}
                {{--                    @foreach ($form->crmFieldCategories() AS $crmFieldCategory)--}}
                {{--                        <option value="{{ $crmFieldCategory->id }}">--}}
                {{--                            {{ $crmFieldCategory->name }}--}}
                {{--                        </option>--}}
                {{--                    @endforeach--}}
                {{--                </x-ccm::forms.select>--}}
                {{--                <x-ccm::forms.select--}}
                {{--                        name="form.crm_field_type_id"--}}
                {{--                        wire:model.live="form.crm_field_type_id"--}}
                {{--                        label="Type"--}}
                {{--                        :disabled="!!$form->id"--}}
                {{--                >--}}
                {{--                    @foreach ($form->crmFieldTypes() AS $crmFieldType)--}}
                {{--                        <option value="{{ $crmFieldType->id }}">--}}
                {{--                            {{ $crmFieldType->name }}--}}
                {{--                        </option>--}}
                {{--                    @endforeach--}}
                {{--                </x-ccm::forms.select>--}}
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                TODO: Wysiwyg etc.
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
