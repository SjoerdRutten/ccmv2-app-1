<div class="flex gap-2 grow">
    <x-ccm::forms.select name="operator" wire:model.live="filterTmp.operator" class="w-[170px]" :disabled="$disabled">
        <option value="">Kies operator</option>
        <option value="eqm">Bevat product</option>
        <option value="neqm">Bevat niet product</option>
    </x-ccm::forms.select>

    <div x-data="{ show: false }">
        <div x-data="productSelect({ value: @entangle('filterTmp.value') })" class="flex items-center gap-4">
                    <span class="mt-1 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100">
                        <span x-text="selectedProducts.length"></span> Producten geselecteerd
                    </span>

            <x-ccm::buttons.primary x-on:click="show = true">Producten selecteren</x-ccm::buttons.primary>
            <x-ccm::layouts.modal
                    title="Producten selecteren"
                    width="2xl"
            >
                <x-ccm::forms.input
                        placeholder="Zoek producten op naam, sku of ean"
                        class="mb-4"
                        x-model.debounce="search"
                />

                <div class="flex gap-4 text-sm">
                    <div class="w-1/2">
                        <div class="flex justify-between">
                                    <span>
                                        Zoekresulaten (<span x-text="searchResult.length"></span>)
                                    </span>
                            <a href="#"
                               class="text-xs hover:underline"
                               x-on:click="addAllProducts"
                               x-show="searchResult.length > 0"
                            >
                                Alles selecteren
                            </a>
                        </div>
                        <div class="h-[200px] overflow-auto border border-gray-300 rounded py-2">
                            <template x-for="product in searchResult">
                                <div
                                        class="flex gap-1 cursor-pointer hover:bg-pink-200 px-2"
                                        x-on:click="addProduct(product.id)"
                                >
                                    <div x-text="product.sku"></div>
                                    -
                                    <div x-text="product.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="flex justify-between">
                                    <span>
                                        Geselecteerd (<span x-text="selectedProducts.length"></span>)
                                    </span>
                            <a href="#"
                               class="text-xs hover:underline"
                               x-on:click="removeAll"
                               x-show="selectedProducts.length > 0"
                            >
                                Leeg maken
                            </a>
                        </div>

                        <div class="h-[200px] overflow-auto border border-gray-300 rounded">
                            <template x-for="(product, index) in selectedProducts">
                                <div
                                        class="flex gap-1 text-sm cursor-pointer hover:bg-pink-200 px-2"
                                        x-on:click="removeProduct(index)"
                                >
                                    <div x-text="product.sku"></div>
                                    -
                                    <div x-text="product.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <x-slot:buttons>
                    <x-ccm::buttons.secundary x-on:click="show = false">
                        Sluiten
                    </x-ccm::buttons.secundary>
                </x-slot:buttons>
            </x-ccm::layouts.modal>
        </div>
    </div>
</div>