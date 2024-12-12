<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail domeinen">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::email_domains::add">Domein toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoeken
                </x-ccm::forms.input>
            </div>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Domein</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>DKIM aanwezig</x-ccm::tables.th>
                <x-ccm::tables.th>DKIM check</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($emailDomains AS $key => $domain)
                    <x-ccm::tables.tr :route="route('admin::email_domains::edit', $domain)">
                        <x-ccm::tables.td :first="true">{{ $domain->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $domain->domain }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $domain->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @if ($domain->hasDkim)
                                <x-heroicon-s-check-circle class="w-6 h-6 text-green-500"/>
                            @else
                                <x-heroicon-s-x-circle class="w-6 h-6 text-red-500"/>
                            @endif
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @if ($domain->dkimCheck)
                                <x-heroicon-s-check-circle class="w-6 h-6 text-green-500 inline"/>
                            @else
                                <x-heroicon-s-x-circle class="w-6 h-6 text-red-500 inline"/>
                            @endif
                            <em class="text-sm">
                                {{ $domain->dkim_status_message }}
                            </em>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('admin::email_domains::overview', $domain)"/>
                            <x-ccm::tables.delete-link
                                    wire:click="removeEmailDomain({{ $domain->id }})"
                                    wire:confirm="Weet je zeker dat je dit domein wilt verwijderen?"
                            />
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $emailDomains->links() }}
    </div>
</div>
