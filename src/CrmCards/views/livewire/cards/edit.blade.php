<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM Kaart wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('crm-cards::cards::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>

            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoek op veldnaam
                </x-ccm::forms.input>
                <x-ccm::forms.select
                        name="categoryId"
                        wire:model.live="filter.category_id"
                        label="Rubriek">
                    <option></option>
                    <option value="-1">Zonder categorie</option>
                    @foreach ($this->form->categories('name') AS $key => $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>
            </div>
        </x-ccm::pages.intro>
        <x-ccm::accordion.base>
            @if (empty($filter['q']))

                <x-ccm::accordion.row title="Algemeen" key="0" :initialState="false">
                    <x-ccm::description-lists.base title="Basisgegevens">
                        <x-ccm::description-lists.element
                                label="CrmID">{{ $crmCard->crm_id }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Laatste IP">{{ $crmCard->latest_ip }}</x-ccm::description-lists.element>
                    </x-ccm::description-lists.base>
                    <x-ccm::description-lists.base title="Statistieken">
                        <x-ccm::description-lists.element
                                label="Datum creatie">{{ $crmCard->created_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Datum mutatie">{{ $crmCard->updated_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Eerste bezoek">{{ $crmCard->first_visit_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Laatste bezoek">{{ $crmCard->latest_visit_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Eerste e-mail">{{ $crmCard->first_email_send_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Laatste e-mail">{{ $crmCard->latest_email_send_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Eerste e-mail geopend">{{ $crmCard->first_email_opened_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Laatste e-mail geopend">{{ $crmCard->latest_email_opened_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Eerste e-mail geklikt">{{ $crmCard->first_email_clicked_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Laatste e-mail geklikt">{{ $crmCard->latest_email_clicked_at?->toDateTimeString() }}</x-ccm::description-lists.element>
                    </x-ccm::description-lists.base>
                    <x-ccm::description-lists.base title="Browser gegevens">
                        <x-ccm::description-lists.element
                                label="Browser">{{ $crmCard->browser }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="OS">{{ $crmCard->browser_os }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Devicetype">{{ $crmCard->browser_device_type }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Device">{{ $crmCard->browser_device }}</x-ccm::description-lists.element>
                    </x-ccm::description-lists.base>
                    <x-ccm::description-lists.base title="Mail client gegevens">
                        <x-ccm::description-lists.element
                                label="Mailclient">{{ $crmCard->mailclient }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="OS">{{ $crmCard->mailclient_os }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Devicetype">{{ $crmCard->mailclient_device_type }}</x-ccm::description-lists.element>
                        <x-ccm::description-lists.element
                                label="Device">{{ $crmCard->mailclient_device }}</x-ccm::description-lists.element>
                    </x-ccm::description-lists.base>
                </x-ccm::accordion.row>

                @if (empty($filter['category_id']) || ($filter['category_id'] < 0))
                    <x-ccm::accordion.row title="Zonder categorie" key="1" :initialState="true">
                        <x-ccm::description-lists.base title="">
                            <x-crm-cards::edit-fields :fields="$this->form->noCategoryFields()" :crmCard="$crmCard"/>
                        </x-ccm::description-lists.base>
                    </x-ccm::accordion.row>
                @endif
                @foreach ($categories AS $key => $category)
                    <x-ccm::accordion.row :title="$category->name" :key="$key + 2" :initialState="true">
                        <x-ccm::description-lists.base title="">
                            <x-crm-cards::edit-fields :fields="$category->crmFields()->isVisible()->get()"
                                                      :crmCard="$crmCard"/>

                        </x-ccm::description-lists.base>
                    </x-ccm::accordion.row>
                @endforeach

            @else
                <x-ccm::accordion.row title="Gevonden velden" key="search" :initialState="true">
                    <x-ccm::description-lists.base title="">
                        <x-crm-cards::edit-fields :fields="$foundFields"
                                                  :crmCard="$crmCard"/>

                    </x-ccm::description-lists.base>
                </x-ccm::accordion.row>
            @endif
        </x-ccm::accordion.base>
    </div>
</div>
