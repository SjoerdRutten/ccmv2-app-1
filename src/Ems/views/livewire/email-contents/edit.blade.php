<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail content">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('ems::emailcontents::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Inhoud HTML-deel</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    @if (!$this->emailContent->isActive)
                        <x-ccm::alerts.warning title="Content is niet actief"></x-ccm::alerts.warning>
                    @endif


                    <x-ccm::forms.input name="form.name" wire:model.live="form.name" :required="true">
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
                    <x-ccm::forms.input-datetime name="form.start_at" wire:model.live="form.start_at">
                        Starttijd
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.input-datetime name="form.end_at" wire:model.live="form.end_at">
                        Eindtijd
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.textarea name="form.remarks" wire:model.blur="form.remarks">
                        Opmerkingen
                    </x-ccm::forms.textarea>
                </div>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.html-editor wire-name="form.content"/>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
