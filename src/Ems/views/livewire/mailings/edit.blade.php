<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Mailing wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('ems::mailings::overview')">Terug</x-ccm::buttons.back>
                @if ($form->start_at)
                    <x-ccm::buttons.save wire:click="save" id="btnSave"></x-ccm::buttons.save>
                @else
                    <x-ccm::buttons.save
                            wire:click="save"
                            wire:confirm="Als je geen starttijd invult zal de mailing direct beginnen met verzenden, weet je dat zeker?"
                            id="btnSave"
                    ></x-ccm::buttons.save>
                @endif
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.name" wire:model="form.name" :required="true">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description" wire:model="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input-datetime name="form.start_at" wire:model.live="form.start_at">
                        Start verzenden op
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.select name="form.email_id" wire:model="form.email_id" :required="true"
                                         label="E-mail">
                        <option></option>
                        @foreach ($emails AS $email)
                            <option value="{{ $email->id }}">
                                {{ $email->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.select name="form.target_group_id" wire:model.live="form.target_group_id"
                                         :required="true"
                                         label="Doelgroep">
                        <option></option>
                        @foreach ($targetGroups AS $targetGroup)
                            <option value="{{ $targetGroup->id }}">
                                {{ $targetGroup->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::loading></x-ccm::loading>
                    @if ($form->target_group_id)
                        <x-ccm::forms.input name="targetGroupCount"
                                            wire:model="targetGroupCount"
                                            disabled>
                            Aantal in doelgroep
                        </x-ccm::forms.input>
                    @endif
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
