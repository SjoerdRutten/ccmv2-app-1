<div x-data="{ show: false }" x-on:refresh-field-sets="show = false">
    <div x-data="fieldSelect({ value: @entangle('selectedIds') })"
         class="flex items-center gap-4">
        <x-ccm::buttons.secundary x-on:click="show = true">Nieuwe veldenset aanmaken</x-ccm::buttons.secundary>
        <x-ccm::layouts.modal
                title="Velden selecteren"
                width="2xl"
        >
            <x-ccm::forms.input
                    class="mb-4"
                    wire:model="name"
            >
                Naam van de veldenset
            </x-ccm::forms.input>

            <hr>

            <x-ccm::forms.input
                    placeholder="Zoek op naam"
                    class="mb-4"
                    x-model.debounce="search"
            />

            <div class="flex gap-4 text-sm">
                <div class="w-1/2">
                    <div class="flex justify-between">
                        <span>
                            Velden (<span x-text="searchResult.length"></span>)
                        </span>
                        <a href="#"
                           class="text-xs hover:underline"
                           x-on:click="addAllFields"
                           x-show="searchResult.length > 0"
                        >
                            Alles selecteren
                        </a>
                    </div>
                    <div class="h-[200px] overflow-auto border border-gray-300 rounded py-2">
                        <template x-for="field in searchResult">
                            <div
                                    class="flex gap-1 cursor-pointer hover:bg-pink-200 px-2"
                                    x-on:click="addField(field.id)"
                            >
                                <div x-text="field.name"></div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="w-1/2">
                    <div class="flex justify-between">
                                    <span>
                                        Geselecteerd (<span x-text="selectedFields.length"></span>)
                                    </span>
                        <a href="#"
                           class="text-xs hover:underline"
                           x-on:click="removeAll"
                           x-show="selectedFields.length > 0"
                        >
                            Leeg maken
                        </a>
                    </div>

                    <div class="h-[200px] overflow-auto border border-gray-300 rounded">
                        <template x-for="(field, index) in selectedFields">
                            <div
                                    class="flex gap-1 text-sm cursor-pointer hover:bg-pink-200 px-2"
                                    x-on:click="removeField(index)"
                            >
                                <div x-text="field.name"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <x-slot:buttons>
                <x-ccm::buttons.save wire:click="save">
                </x-ccm::buttons.save>
                <x-ccm::buttons.secundary x-on:click="show = false">
                    Sluiten
                </x-ccm::buttons.secundary>

            </x-slot:buttons>
        </x-ccm::layouts.modal>
    </div>
</div>
