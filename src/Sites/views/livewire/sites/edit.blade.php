<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Site wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('cms::sites::overview')">Terug</x-ccm::buttons.back>
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
                                        wire:model.live="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description"
                                        wire:model.live="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.domain"
                                        wire:model.live="form.domain"
                                        :required="true"
                    >
                        Domeinnaam (https://)
                    </x-ccm::forms.input>
                    @if (count($sitePages))
                        <x-ccm::forms.select label="Homepagina" wire:model.live="form.site_page_id">
                            <option></option>
                            @foreach ($sitePages AS $sitePage)
                                <option value="{{ $sitePage->id }}">
                                    {{ $sitePage->name }}
                                </option>
                            @endforeach
                        </x-ccm::forms.select>
                    @endif
                    <x-ccm::forms.input-file name="form.favicon"
                                             wire:model.live="form.favicon"
                    >
                        Favicon
                        <x-slot:preview>
                            @if ($site->favicon)
                                <img src="{{ route('frontend::favicon', $site) }}" class="w-[16px] h-[16px]"/>
                            @endif
                        </x-slot:preview>
                    </x-ccm::forms.input-file>


                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
