<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Layout wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::layouts::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Meta informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="4">Blokken</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Body</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="3">CSS/JS</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
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
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.meta_title"
                                        wire:model="form.meta_title"
                    >
                        Meta title (max. 64 karakters)
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.meta_description"
                                        wire:model="form.meta_description"
                    >
                        Meta description (max. 150 karakters)
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.meta_keywords"
                                        wire:model="form.meta_keywords"
                    >
                        Meta keywords
                    </x-ccm::forms.input>
                    <x-ccm::forms.checkbox name="form.follow" wire:model="form.follow">
                        Follow
                    </x-ccm::forms.checkbox>
                    <x-ccm::forms.checkbox name="form.index" wire:model="form.index">
                        Index
                    </x-ccm::forms.checkbox>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::forms.html-editor wire-name="form.body"></x-ccm::forms.html-editor>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-ccm::forms.select label="CSS" wire:model.live="importId">
                            <option></option>
                            @foreach ($importsCSS AS $import)
                                <option value="{{ $import->id }}">
                                    {{ $import->name }}
                                </option>
                            @endforeach
                        </x-ccm::forms.select>

                        <x-ccm::sortable-list.ul
                                x-data="{ handle: (item, position) => { $wire.reOrderSiteImport(item, position) } }">
                            @foreach ($layoutImportCss AS $import)
                                <x-ccm::sortable-list.li :id="$import->id">
                                    <div class="grow truncate ...">
                                        {{ $import->name }}
                                    </div>
                                    <x-ccm::buttons.delete
                                            wire:click.prevent="removeImportFromList({{ $import->id }})"></x-ccm::buttons.delete>
                                </x-ccm::sortable-list.li>
                            @endforeach
                        </x-ccm::sortable-list.ul>

                    </div>
                    <div>
                        <x-ccm::forms.select label="JS" wire:model.live="importId">
                            <option></option>
                            @foreach ($importsJS AS $import)
                                <option value="{{ $import->id }}">
                                    {{ $import->name }}
                                </option>
                            @endforeach
                        </x-ccm::forms.select>

                        <x-ccm::sortable-list.ul
                                x-data="{ handle: (item, position) => { $wire.reOrderSiteImport(item, position) } }">
                            @foreach ($layoutImportJs AS $import)
                                <x-ccm::sortable-list.li :id="$import->id">
                                    <div class="grow truncate ...">
                                        {{ $import->name }}
                                    </div>
                                    <x-ccm::buttons.delete
                                            wire:click.prevent="removeImportFromList({{ $import->id }})"></x-ccm::buttons.delete>
                                </x-ccm::sortable-list.li>
                            @endforeach
                        </x-ccm::sortable-list.ul>
                    </div>
                </div>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="4">

                <x-ccm::sortable-list.ul
                        x-data="{ handle: (item, position) => { $wire.reOrderBlocks(item, position) } }">
                    @php($index = 0)
                    @foreach ($this->form->config ?? [] AS $key => $row)
                        <x-ccm::sortable-list.li :id="$index">
                            <x-ccm::forms.input wire:model.blur="form.config.{{ $key }}.key">Naam</x-ccm::forms.input>
                            <x-ccm::forms.input wire:model="form.config.{{ $key }}.description" :grow="true">
                                Omschrijving
                            </x-ccm::forms.input>
                            <x-ccm::forms.checkbox wire:model="form.config.{{ $key }}.multiple">
                                Multiple
                            </x-ccm::forms.checkbox>
                            <x-ccm::buttons.delete
                                    wire:click.prevent="removeBlockFromList('{{ $key }}')"/>
                        </x-ccm::sortable-list.li>
                        @php($index++)
                    @endforeach
                </x-ccm::sortable-list.ul>
                <div class="flex mt-4">
                    <x-ccm::buttons.add wire:click="addBlock">Blok toevoegen</x-ccm::buttons.add>
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
