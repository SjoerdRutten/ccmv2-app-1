<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro :title="'Scraper wijzigen '.$siteScraper->name">
            <x-slot:title_tags>
                @if ($siteScraper->status === 'new')
                    <x-ccm::tags.ccm>Nieuw</x-ccm::tags.ccm>
                @elseif ($siteScraper->status === 'running')
                    <x-ccm::tags.warning>Running</x-ccm::tags.warning>
                @elseif ($siteScraper->status === 'failed')
                    <x-ccm::tags.error>Mislukt</x-ccm::tags.error>
                @elseif ($siteScraper->status === 'done')
                    <x-ccm::tags.success>
                        {{ $siteScraper->last_scraped_at->toDateTimeString('minute') }}
                    </x-ccm::tags.success>
                @endif
            </x-slot:title_tags>
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::scrapers::overview')">Terug</x-ccm::buttons.back>
                @if ($siteScraper->id)
                    <x-ccm::buttons.success wire:click="run" icon="heroicon-s-play">Uitvoeren</x-ccm::buttons.success>
                @endif
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
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
                    <x-ccm::forms.input name="form.url"
                                        wire:model="form.url"
                                        :required="true"
                    >
                        Bron URL
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.base_url"
                                        wire:model="form.base_url"
                                        :required="true"
                    >
                        Basis URL
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.target"
                                         wire:model.live="form.target"
                                         :required="true"
                                         label="Doel module"
                    >
                        <option></option>
                        <option value="layout">Layout</option>
                        <option value="block">Contentblok</option>
                    </x-ccm::forms.select>

                    @if ($this->form->target === 'layout')
                        <div x-data="{ current: @entangle('form.current') }">
                            <div x-show="current">
                                <x-ccm::forms.select name="form.site_layout_id"
                                                     wire:model.live="form.site_layout_id"
                                                     label="Bestaande layout"
                                >
                                    <option></option>
                                    @foreach ($siteLayouts AS $siteLayout)
                                        <option value="{{ $siteLayout->id }}">
                                            {{ $siteLayout->name }}
                                        </option>
                                    @endforeach
                                </x-ccm::forms.select>
                            </div>
                            <div x-show="!current">
                                <x-ccm::forms.input name="form.layout_name"
                                                    wire:model="form.layout_name"
                                >
                                    Naam nieuwe layout
                                </x-ccm::forms.input>
                            </div>

                            <x-ccm::layouts.link x-on:click.prevent="current = false" x-show="current">
                                Nieuwe layout aanmaken
                            </x-ccm::layouts.link>
                            <x-ccm::layouts.link x-on:click.prevent="current = true" x-show="!current">
                                Bestaande layout kiezen
                            </x-ccm::layouts.link>
                        </div>
                    @else
                        <div x-data="{ current: @entangle('form.current') }">
                            <div x-show="current">
                                <x-ccm::forms.select name="form.site_block_id"
                                                     wire:model.live="form.site_block_id"
                                                     :required="true"
                                                     label="Contentblok"
                                >
                                    <option></option>
                                    @foreach ($siteBlocks AS $siteBlock)
                                        <option value="{{ $siteBlock->id }}">
                                            {{ $siteBlock->name }}
                                        </option>
                                    @endforeach
                                </x-ccm::forms.select>
                            </div>
                            <div x-show="!current">
                                <x-ccm::forms.input name="form.block_name"
                                                    wire:model="form.block_name"
                                >
                                    Naam nieuw contentblok
                                </x-ccm::forms.input>
                            </div>

                            <x-ccm::layouts.link x-on:click.prevent="current = false" x-show="current">
                                Nieuw contentblok aanmaken
                            </x-ccm::layouts.link>
                            <x-ccm::layouts.link x-on:click.prevent="current = true" x-show="!current">
                                Bestaand contentblok kiezen
                            </x-ccm::layouts.link>

                            <x-ccm::forms.input name="form.start_selector"
                                                wire:model="form.start_selector"
                            >
                                Blok selector (b.v. body > .wrapper)
                            </x-ccm::forms.input>

                        </div>
                    @endif

                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
