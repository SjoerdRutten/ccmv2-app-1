<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Rol wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('roles::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Gegevens</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Gebruikers</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form>
                    <x-ccm::forms.input name="form.name" wire:model.live="form.name">Naam</x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::tables.table>
                    <x-slot:thead>
                        <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                        <x-ccm::tables.th>Naam</x-ccm::tables.th>
                        <x-ccm::tables.th>E-mail</x-ccm::tables.th>
                        <x-ccm::tables.th>Last login</x-ccm::tables.th>
                        <x-ccm::tables.th :link="true"></x-ccm::tables.th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($role->users()->orderBy('name')->get() AS $key => $user)
                            <x-ccm::tables.tr>
                                <x-ccm::tables.td :first="true">{{ $user->id }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $user->name }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $user->email }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $user->last_login }}</x-ccm::tables.td>
                                <x-ccm::tables.td :link="true">
                                    <x-ccm::buttons._icon_button
                                            icon="heroicon-s-arrow-right-end-on-rectangle"
                                            class="text-pink-500"
                                            title="Login als"
                                            wire:click="loginAs({{ $user->id }})"
                                    ></x-ccm::buttons._icon_button>
                                    {{--                                    <x-ccm::tables.edit-link :href="route('roles::edit', $role)"/>--}}
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                </x-ccm::tables.table>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
