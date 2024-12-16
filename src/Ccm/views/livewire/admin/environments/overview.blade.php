<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Omgevingen">
            <x-slot:actions>
                <x-ccm::buttons.add route="admin::environments::add">Omgeving toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Klant</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>E-mail credits</x-ccm::tables.th>
                <x-ccm::tables.th></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($environments AS $key => $environment)
                    <x-ccm::tables.tr :route="route('admin::environments::edit', $environment)">
                        <x-ccm::tables.td :first="true">{{ $environment->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $environment->customer->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $environment->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $environment->email_credits }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link
                                    :href="route('admin::environments::edit', $environment)"></x-ccm::tables.edit-link>
                            <x-ccm::tables.delete-link
                                    wire:confirm="Weet je zeker dat je deze omgeving wilt verwijderen?"
                                    wire:click="removeEnvironment({{ $environment->id }})"></x-ccm::tables.delete-link>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
