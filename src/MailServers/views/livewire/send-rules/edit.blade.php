<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Verzendregel wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::sendrules::overview')">Terug</x-ccm::buttons.back>
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
                    <x-ccm::forms.checkbox name="form.is_active"
                                           wire:model="form.is_active">
                        Actief
                    </x-ccm::forms.checkbox>
                </x-ccm::forms.form>
                <x-ccm::typography.h2 class="mt-8">Voorwaarden</x-ccm::typography.h2>
                @foreach ($this->form->rules AS $key => $rule)
                    <div class="flex gap-4">
                        <div class="w-1/3">
                            <x-ccm::forms.select wire:model.live="form.rules.{{ $key }}.check">
                                <option></option>
                                <option value="sender_eq">Verzender is gelijk aan</option>
                                <option value="sender_neq">Verzender is niet gelijk aan</option>
                                <option value="senderdomain_eq">Verzenddomein is gelijk aan</option>
                                <option value="senderdomain_neq">Verzenddomein is niet gelijk aan</option>
                                <option value="senderdomain_contains">Verzenddomein bevat</option>
                                <option value="senderdomain_notcontains">Verzenddomein bevat niet</option>
                                <option value="receiverdomain_eq">Ontvangerdomein is gelijk aan</option>
                                <option value="receiverdomain_neq">Ontvangerdomein is niet gelijk aan</option>
                                <option value="receiverdomain_contains">Ontvangerdomein bevat</option>
                                <option value="receiverdomain_notcontains">Ontvangerdomein bevat niet</option>
                                <option value="total_lt">Totaal aantal verzonden mails via deze regel is kleiner dan
                                </option>
                            </x-ccm::forms.select>
                        </div>
                        <div class="flex-grow">
                            @if (!empty($this->form->rules[$key]['check']))
                                <x-ccm::forms.input wire:model="form.rules.{{ $key }}.value"/>
                            @endif
                        </div>
                        <x-ccm::buttons.delete wire:click="removeRule('{{ $key }}')"></x-ccm::buttons.delete>
                    </div>
                @endforeach

                <x-ccm::buttons.primary wire:click.prevent="addRule" class="mt-4">
                    Voorwaarde toevoegen
                </x-ccm::buttons.primary>

                <x-ccm::typography.h2 class="mt-8">Verzenden via</x-ccm::typography.h2>
                @foreach ($this->form->mailServers AS $key => $row)
                    <div class="flex gap-4">
                        <div class="w-1/3">
                            <x-ccm::forms.select wire:model.live="form.mailServers.{{ $key }}.mailServerId">
                                <option></option>
                                @foreach ($mailServers AS $mailServer)
                                    <option value="{{ $mailServer->id }}">
                                        {{ $mailServer->host }}
                                    </option>
                                @endforeach
                            </x-ccm::forms.select>
                        </div>
                        <div class="flex-grow">
                            @if (!empty($this->form->mailServers[$key]['mailServerId']))
                                <x-ccm::forms.input wire:model="form.mailServers.{{ $key }}.priority"
                                                    placeholder="prioriteit"/>
                            @endif
                        </div>
                        <x-ccm::buttons.delete wire:click="removeMailServer('{{ $key }}')"></x-ccm::buttons.delete>
                    </div>
                @endforeach

                <x-ccm::buttons.primary wire:click.prevent="addMailServer" class="mt-4">
                    Mailserver toevoegen
                </x-ccm::buttons.primary>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
