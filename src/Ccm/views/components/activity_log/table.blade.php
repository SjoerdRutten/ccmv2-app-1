<x-ccm::tables.table :no-margin="true">
    <x-slot:thead>
        <x-ccm::tables.th :first="true">Actie</x-ccm::tables.th>
        <x-ccm::tables.th>Gebruiker</x-ccm::tables.th>
        <x-ccm::tables.th>Datum / tijd</x-ccm::tables.th>
    </x-slot:thead>
    <x-slot:tbody>
        @foreach ($activities AS $activity)
            <x-ccm::tables.tr>
                <x-ccm::tables.td :first="true">{{ $activity->event }}</x-ccm::tables.td>
                <x-ccm::tables.td>{{ $activity->causer->name }}</x-ccm::tables.td>
                <x-ccm::tables.td>{{ $activity->created_at }}</x-ccm::tables.td>
            </x-ccm::tables.tr>
        @endforeach
    </x-slot:tbody>
</x-ccm::tables.table>