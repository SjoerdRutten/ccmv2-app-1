<div class="flex items-end" x-data="{ show: false }">
    <div class="flex-grow">
        <x-ccm::forms.select label="Categorie" {{ $attributes }}>
            <option></option>
            @foreach ($categories AS $_category)
                <option value="{{ $_category->id }}">
                    {{ $_category->name }}
                </option>
            @endforeach
        </x-ccm::forms.select>
    </div>
    <a href="#" x-on:click="show = true" class="ml-2 mb-3">
        <x-heroicon-c-plus-circle class="w-5 h-5"/>
    </a>
    <x-ccm::layouts.modal title="Categorie toevoegen">
        <x-ccm::forms.form class="w-full">
            <x-ccm::forms.input name="add_category_name" wire:model="add_category_name">Naam</x-ccm::forms.input>
        </x-ccm::forms.form>

        <x-slot:buttons>
            <x-ccm::buttons.primary wire:click.prevent="saveAddCategory" x-on:click="show = false">
                Opslaan
            </x-ccm::buttons.primary>
            <x-ccm::buttons.secundary x-on:click="show = false">
                Annuleren
            </x-ccm::buttons.secundary>
        </x-slot:buttons>
    </x-ccm::layouts.modal>
</div>