<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Pagina wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::pages::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>

            @if ($sitePage->siteLayout)
                <x-ccm::layouts.link
                        href="{{ route('cms::layouts::edit', $sitePage->siteLayout->id) }}">{{ $sitePage->siteLayout->name }}</x-ccm::layouts.link>
            @endif
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Blokken</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.select name="form.site_id"
                                         wire:model.live="form.site_id"
                                         label="Site"
                    >
                        <option></option>
                        @foreach ($sites AS $site)
                            <option value="{{ $site->id }}">
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.name"
                                        wire:model.blur="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.slug"
                                        wire:model.blur="form.slug"
                                        :required="true"
                    >
                        Slug
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.site_layout_id"
                                         wire:model.live="form.site_layout_id"
                                         :required="true"
                                         label="Layout"
                    >
                        <option></option>
                        @foreach ($siteLayouts AS $siteLayout)
                            <option value="{{ $siteLayout->id }}">
                                {{ $siteLayout->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.description"
                                        wire:model="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input-datetime name="form.start_at"
                                                 wire:model="form.start_at"
                    >
                        Publicatie starttijd
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.input-datetime name="form.end_at"
                                                 wire:model="form.end_at"
                    >
                        Publicatie eindtijd
                    </x-ccm::forms.input-datetime>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::cards.cards>
                    @foreach ($this->layoutConfigBlocks AS $key => $block)
                        <x-ccm::cards.card :title="$block['key']" :subtitle="$block['description']">
                            @if ($block['multiple'])
                                <x-ccm::sortable-list.ul
                                        class="mt-4"
                                        x-data="{ handle: (item, position) => { $wire.reOrderBlocks('{{ $block['key'] }}', item, position) } }">
                                    @foreach ($this->form->config[$block['key']] ?? [] AS $key => $row)
                                        <x-ccm::sortable-list.li :id="$key">
                                            <div class="grow">
                                                <x-ccm::forms.select
                                                        wire:model="form.config.{{ $block['key'] }}.{{ $key }}"
                                                        label="Contentblok">
                                                    <option></option>
                                                    @foreach ($siteBlocks AS $siteBlock)
                                                        <option value="{{ $siteBlock->id }}">
                                                            {{ $siteBlock->name }}
                                                        </option>
                                                    @endforeach
                                                </x-ccm::forms.select>
                                                <x-ccm::buttons.delete
                                                        wire:click.prevent="removeBlockFromList('{{ $block['key'] }}', {{ $key }})"/>
                                            </div>
                                        </x-ccm::sortable-list.li>
                                    @endforeach
                                    <x-ccm::buttons.add wire:click="addBlockToList('{{ $block['key'] }}')" class="mb-4">
                                        Blok toevoegen
                                    </x-ccm::buttons.add>
                                </x-ccm::sortable-list.ul>
                            @else
                                <x-ccm::forms.select wire:model="form.config.{{ $block['key'] }}"
                                                     label="Contentblok">
                                    <option></option>
                                    @foreach ($siteBlocks AS $siteBlock)
                                        <option value="{{ $siteBlock->id }}">
                                            {{ $siteBlock->name }}
                                        </option>
                                    @endforeach
                                </x-ccm::forms.select>
                            @endif
                        </x-ccm::cards.card>
                    @endforeach
                </x-ccm::cards.cards>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
