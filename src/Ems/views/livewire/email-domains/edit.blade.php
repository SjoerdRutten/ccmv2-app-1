<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail domein">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::email_domains::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">
                    DKIM
                    <x-slot:badge>
                        {{ $emailDomain->emailDkims()->count() }}
                    </x-slot:badge>
                </x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.domain" wire:model.live="form.domain">
                        Domeinnaam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description" wire:model.live="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.return_path" wire:model.live="form.return_path">
                        Return-path ('envelope sender') aligned met domeinnaam
                        (i.p.v. systeemwaarde@ccmprofessional.com)
                    </x-ccm::forms.input>
                </div>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1" :no-margin="true">
                <x-ccm::tables.table>
                    <x-slot:thead>
                        <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                        <x-ccm::tables.th>Selector</x-ccm::tables.th>
                        <x-ccm::tables.th>Verloopt op</x-ccm::tables.th>
                        <x-ccm::tables.th>Status</x-ccm::tables.th>
                        <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($emailDomain->emailDkims AS $emailDkim)
                            <x-ccm::tables.tr
                                    x-on:dblclick="$wire.editDkim({{ $emailDkim->id }})"
                            >
                                <x-ccm::tables.td :first="true">{{ $emailDkim->id }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $emailDkim->selector_prefix }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $emailDkim->expires_at }}</x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    @if ($emailDkim->status)
                                        <x-heroicon-s-check-circle class="w-6 h-6 text-green-500 inline"/>
                                    @else
                                        <x-heroicon-s-x-circle class="w-6 h-6 text-red-500 inline"/>
                                    @endif
                                    <em class="text-sm">
                                        {{ $emailDkim->status_message }}
                                    </em>
                                </x-ccm::tables.td>
                                <x-ccm::tables.td :link="true">
                                    <x-ccm::tables.view-link
                                            wire:click="editDkim({{ $emailDkim->id }})"></x-ccm::tables.view-link>
                                    <x-ccm::tables.delete-link
                                            wire:confirm="Weet je zeker dat je deze DKIM wilt verwijderen ?"
                                            wire:click="removeDkim({{ $emailDkim->id }})"
                                    ></x-ccm::tables.delete-link>
                                    <x-ccm::tables.refresh-link
                                            wire:click="refreshDkimCheck({{ $emailDkim->id }})"
                                    ></x-ccm::tables.refresh-link>
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                    <x-slot:postTable>
                        <div class="flex flex-row-reverse mx-2 py-2">
                            <x-ccm::buttons.add wire:click="addDkim">DKIM toevoegen</x-ccm::buttons.add>
                        </div>
                    </x-slot:postTable>
                </x-ccm::tables.table>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
    <div x-data="{ show: @entangle('showDkimModal') }">
        <x-ccm::layouts.modal
                title="DKIM bewerken"
        >
            <x-ccm::forms.form class="w-full">
                @if ($dkimForm->id)
                    <x-ccm::forms.input name="dkimForm.selector_prefix" wire:model.live="dkimForm.selector_prefix"
                                        :disabled="true">
                        Selector prefix
                    </x-ccm::forms.input>

                    <x-ccm::forms.input name="form.dkim_expires_at"
                                        value="{{ $dkimForm->emailDkim->expires_at }}"
                                        :disabled="true">
                        Verloopt op
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="dkimKey"
                                        value="{{ $dkimForm->emailDkim->dnsRecordKey }}"
                                        :disabled="true">
                        DNS Record key
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="dkim"
                                        value="{{ $dkimForm->emailDkim->dnsRecordValue }}"
                                        :disabled="true">
                        DNS Record value
                    </x-ccm::forms.input>
                @else
                    <x-ccm::forms.input name="dkimForm.selector_prefix" wire:model.live="dkimForm.selector_prefix">
                        Selector prefix
                    </x-ccm::forms.input>
                @endif
            </x-ccm::forms.form>

            <x-slot:buttons>
                <x-ccm::buttons.primary wire:click.prevent="saveDkim">
                    DKIM Opslaan
                </x-ccm::buttons.primary>
                <x-ccm::buttons.secundary x-on:click="show = false">
                    Annuleren
                </x-ccm::buttons.secundary>
            </x-slot:buttons>
        </x-ccm::layouts.modal>
    </div>
</div>


{{--    <x-ccm::buttons.primary wire:click="generateDkim">Genereer DKIM</x-ccm::buttons.primary>--}}
{{--</div>--}}
