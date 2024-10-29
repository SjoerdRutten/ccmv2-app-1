<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro :title="$collectionName"></x-ccm::pages.intro>

        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th>Veld</x-ccm::tables.th>
                <x-ccm::tables.th>Type</x-ccm::tables.th>
                <x-ccm::tables.th>Index</x-ccm::tables.th>
                <x-ccm::tables.th>Optioneel</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($fields AS $field)
                    <x-ccm::tables.tr>
                        <x-ccm::tables.td :first="true">{{ $field['name'] }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $field['type'] }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $field['index'] ? 'Ja' : 'Nee' }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $field['optional'] ? 'Ja' : 'Nee' }}</x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
