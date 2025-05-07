<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Server wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::servers::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Gegevens</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Status</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form>
                    <x-ccm::forms.input name="form.name" wire:model="form.name" :required="true">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.type" wire:model="form.type" label="Soort server" :required="true">
                        <option></option>
                        <option value="app">App</option>
                        <option value="api">Api</option>
                        <option value="db">Database</option>
                        <option value="redis">Redis</option>
                        <option value="worker">Worker</option>
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.ip" wire:model="form.ip" :required="true">
                        IP-adres
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <div class="flex">
                    <x-ccm::tables.table>
                        <x-slot:tbody>
                            <x-ccm::tables.tr>
                                <x-ccm::tables.th>Laatste update</x-ccm::tables.th>
                                <x-ccm::tables.td
                                        class="text-right">{{ $server->status?->created_at?->toDateTimeString() }}</x-ccm::tables.td>
                            </x-ccm::tables.tr>
                            <x-ccm::tables.tr>
                                <x-ccm::tables.th>Schijfruimte totaal</x-ccm::tables.th>
                                <x-ccm::tables.td
                                        class="text-right">{{ \Illuminate\Support\Number::fileSize($server->status?->disk_total_space, 2) }}</x-ccm::tables.td>
                            </x-ccm::tables.tr>
                            <x-ccm::tables.tr>
                                <x-ccm::tables.th>Schijfruimte vrij</x-ccm::tables.th>
                                <x-ccm::tables.td
                                        class="text-right">{{ \Illuminate\Support\Number::fileSize($server->status?->disk_free_space, 2) }}</x-ccm::tables.td>
                            </x-ccm::tables.tr>
                            <x-ccm::tables.tr>
                                <x-ccm::tables.th>RAM totaal</x-ccm::tables.th>
                                <x-ccm::tables.td
                                        class="text-right">{{ \Illuminate\Support\Number::fileSize($server->status?->ram_total_space, 2) }}</x-ccm::tables.td>
                            </x-ccm::tables.tr>
                            <x-ccm::tables.tr>
                                <x-ccm::tables.th>RAM vrij</x-ccm::tables.th>
                                <x-ccm::tables.td
                                        class="text-right">{{ \Illuminate\Support\Number::fileSize($server->status?->ram_free_space, 2) }}</x-ccm::tables.td>
                            </x-ccm::tables.tr>
                            <x-ccm::tables.tr>
                                <x-ccm::tables.th>CPU Load</x-ccm::tables.th>
                                <x-ccm::tables.td
                                        class="text-right">{{ $server->cpuPercentage }}%
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        </x-slot:tbody>
                    </x-ccm::tables.table>
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
