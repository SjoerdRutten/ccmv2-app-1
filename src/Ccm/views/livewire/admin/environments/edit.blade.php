<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Omgeving wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::environments')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Gegevens</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">
                    E-mail credits
                    <x-slot:badge>{{ ReadableNumber($environment->activeEmailCredits, '.') }}</x-slot:badge>
                </x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form>
                    <x-ccm::forms.select label="Klant" wire:model="form.customer_id">
                        <option></option>
                        @foreach ($this->form->getCustomers() AS $key => $name)
                            <option value="{{ $key }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.select label="Tijdzone" wire:model="form.timezone_id">
                        @foreach ($this->form->getTimezones() AS $key => $name)
                            <option value="{{ $key }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>

                    <x-ccm::forms.input name="form.name" wire:model="form.name" maxlength="40">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description" wire:model="form.description" maxlength="80">
                        Omschrijving
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.form class="grid grid-cols-2">
                    <div class="flex flex-col gap-4">
                        <x-ccm::forms.input type="number" step="1" name="emailCreditsForm.quantity"
                                            wire:model="emailCreditsForm.quantity">
                            Aantal
                        </x-ccm::forms.input>
                        <x-ccm::buttons.add wire:click="addEmailCredits">E-mail credits toevoegen</x-ccm::buttons.add>
                    </div>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1" :no-margin="true">
                <x-ccm::tables.table>
                    <x-slot:thead>
                        <x-ccm::tables.th :first="true">Aantal</x-ccm::tables.th>
                        <x-ccm::tables.th>Toegevoegd op</x-ccm::tables.th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($environment->emailCredits AS $emailCredit)
                            <x-ccm::tables.tr>
                                <x-ccm::tables.td :first="true">
                                    {{ $emailCredit->quantity }}
                                </x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    {{ $emailCredit->created_at }}
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                </x-ccm::tables.table>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
