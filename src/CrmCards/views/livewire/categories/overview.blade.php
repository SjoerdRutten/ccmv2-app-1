<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM Velden">
            <x-slot:actions>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Type</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($crmFields AS $crmField)
                    <tr>
                        <x-ccm::tables.td :first="true">{{ $crmField->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmField->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmField->label }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmField->type }}</x-ccm::tables.td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
