<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM Veld wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('crm-cards::fields::overview')">Terug</x-ccm::buttons.back>
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
                <x-ccm::forms.form>
                    <x-ccm::forms.input name="form.name" wire:model.live="form.name">Naam</x-ccm::forms.input>
                    <x-ccm::forms.input name="form.label" wire:model.live="form.label">Omschrijving Nederlands
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.label_en" wire:model.live="form.label_en">Omschrijving Engels
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.label_de" wire:model.live="form.label_de">Omschrijving Duits
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.label_fr" wire:model.live="form.label_fr">Omschrijving Frans
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.crm_field_category_id"
                            wire:model.live="form.crm_field_category_id"
                            label="Rubriek"
                    >
                        <option></option>
                        @foreach ($form->crmFieldCategories() AS $crmFieldCategory)
                            <option value="{{ $crmFieldCategory->id }}">
                                {{ $crmFieldCategory->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.select
                            name="form.crm_field_type_id"
                            wire:model.live="form.crm_field_type_id"
                            label="Type"
                            :disabled="!!$form->id"
                    >
                        <option></option>
                        @foreach ($form->crmFieldTypes() AS $crmFieldType)
                            <option value="{{ $crmFieldType->id }}">
                                {{ $crmFieldType->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.form>
                    <x-ccm::forms.checkbox name="form.is_shown_on_overview" wire:model.live="form.is_shown_on_overview">
                        Overzicht
                    </x-ccm::forms.checkbox>
                    <x-ccm::forms.checkbox name="form.is_shown_on_target_group_builder"
                                           wire:model.live="form.is_shown_on_target_group_builder">Doelgroep selectie
                    </x-ccm::forms.checkbox>
                    <x-ccm::forms.checkbox name="form.is_hidden" wire:model.live="form.is_hidden">Verborgen
                    </x-ccm::forms.checkbox>
                    <x-ccm::forms.checkbox name="form.is_locked" wire:model.live="form.is_locked">Vergrendeld
                    </x-ccm::forms.checkbox>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::typography.h2>
                    Stap 1: Correctie van veldwaarde vóór validatie
                    <span class="text-xs">(optioneel)</span>
                </x-ccm::typography.h2>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        @foreach ($form->preProcessingRules AS $key => $processingRule)
                            <livewire:crm-cards::fields::rule wire:model="form.preProcessingRules.{{ $key }}"
                                                              wire:key="pre{{ $key }}"
                                                              :key="$key"
                                                              rule-type="preProcessingRules"
                                                              :rule-key="$key"
                            />
                        @endforeach
                        <x-ccm::buttons.primary wire:click="addPreProcessingRule">
                            Regel toevoegen
                        </x-ccm::buttons.primary>

                        <x-ccm::typography.h2>
                            Stap 2: Validatie van veldwaarde
                            <span class="text-xs">(verplicht)</span>
                        </x-ccm::typography.h2>
                        <x-ccm::buttons.primary wire:click="addValidationRule">Regel toevoegen</x-ccm::buttons.primary>


                        <x-ccm::typography.h2>
                            Stap 3: Correctie van veldwaarde ná validatie
                            <span class="text-xs">(optioneel)</span>
                        </x-ccm::typography.h2>

                        @foreach ($form->postProcessingRules AS $key => $processingRule)
                            <livewire:crm-cards::fields::rule wire:model="form.postProcessingRules.{{ $key }}"
                                                              wire:key="post{{ $key }}"
                                                              :key="$key"
                                                              rule-type="postProcessingRules"
                                                              :rule-key="$key"
                            />
                        @endforeach

                        <x-ccm::buttons.primary wire:click="addPostProcessingRule">Regel toevoegen
                        </x-ccm::buttons.primary>
                    </div>
                    <div class="grow">
                        <x-ccm::forms.input wire:model.blur="testValue">Test value</x-ccm::forms.input>

                        @if (!empty($testValue))
                            <p class="text-center block my-4">
                                Resulteert in:
                            </p>

                            <div class="bg-gray-200 border border-gray-300 rounded text-center py-4 text-lg mb-2">
                                @if ($correctedValue === false)
                                    <span class="text-red-500">
                                        Deze invoer kan niet gecorrigeerd worden
                                    </span>

                                @else
                                    {{ $correctedValue }}
                                @endif
                            </div>
                        @endif

                        <x-ccm::buttons.primary wire:click="getCorrectedValue">Test</x-ccm::buttons.primary>

                    </div>
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
