<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Gebruikers">
            <div class="flex flex-row gap-4">
                <x-ccm::forms.input name="q" wire:model.live="q">Zoeken</x-ccm::forms.input>
                <x-ccm::forms.select name="is_active" wire:model.live="is_active" label="Actief">
                    <option value="">Alles</option>
                    <option value="0">Niet actief</option>
                    <option value="1">Actief</option>
                </x-ccm::forms.select>
            </div>
            <x-slot:actions>
                {{--                <x-ccm::buttons.add route="roles::edit">Rol toevoegen</x-ccm::buttons.add>--}}
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Gebruikersnaam</x-ccm::tables.th>
                <x-ccm::tables.th>Actief</x-ccm::tables.th>
                <x-ccm::tables.th>Laatste login</x-ccm::tables.th>
                <x-ccm::tables.th>Rollen</x-ccm::tables.th>
                <x-ccm::tables.th :link="true"></x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($this->getUsers() AS $key => $user)
                    <x-ccm::tables.tr :route="route('users::edit', $user)">
                        <x-ccm::tables.td :first="true">{{ $user->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $user->first_name }} {{ $user->suffix }} {{ $user->last_name }}
                            <x-slot:sub>
                                {{ $user->email }}
                            </x-slot:sub>
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            {{ $user->name }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @if ($user->active)
                                <x-ccm::tags.success>Actief</x-ccm::tags.success>
                            @else
                                <x-ccm::tags.error>Inactief</x-ccm::tags.error>
                            @endif
                        </x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $user->last_login }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @foreach ($user->roles AS $role)
                                <x-ccm::tags.ccm>{{ $role->name }}</x-ccm::tags.ccm>
                            @endforeach
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('users::edit', $user)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
