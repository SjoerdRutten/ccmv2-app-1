<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Klanten"></x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>E-mail</x-ccm::tables.th>
                <x-ccm::tables.th>Telefoon</x-ccm::tables.th>
                <x-ccm::tables.th></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($customers AS $key => $customer)
                    <x-ccm::tables.tr :route="route('admin::customers.edit', $customer)">
                        <x-ccm::tables.td :first="true">{{ $customer->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $customer->email }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $customer->telephone }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link
                                    :href="route('admin::customers.edit', $customer)"></x-ccm::tables.edit-link>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
