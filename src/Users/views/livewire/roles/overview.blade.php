<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Rollen">
            <x-slot:actions>
                <x-ccm::buttons.add route="roles::edit">Rol toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Admin</x-ccm::tables.th>
                <x-ccm::tables.th>Aantal gebruikers</x-ccm::tables.th>
                <x-ccm::tables.th :link="true"></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($roles AS $key => $role)
                    <x-ccm::tables.tr :route="route('roles::edit', $role)">
                        <x-ccm::tables.td :first="true">{{ $role->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $role->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @if ($role->is_admin)
                                <x-heroicon-s-check-circle class="text-green-500 w-6 h-6"/>
                            @endif
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $role->users()->count() }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('roles::edit', $role)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
