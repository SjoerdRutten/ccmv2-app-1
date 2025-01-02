<div wire:loading.remove x-data="{ show: @entangle('showModal') }">
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Meldingen">
            <x-slot:actions>
                @if (count($checkedNotifications))
                    <x-ccm::buttons.primary wire:click="markAsRead(false)">
                        Markeer selectie als gelezen
                    </x-ccm::buttons.primary>
                @elseif (count($unreadNotifications))
                    <x-ccm::buttons.primary wire:click="markAsRead(true)">
                        Alles markeren als gelezen
                    </x-ccm::buttons.primary>
                @endif
            </x-slot:actions>
        </x-ccm::pages.intro>


        <x-ccm::tabs.base as="notifications">
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">
                    Ongelezen
                    @if ($unreadNotificationsCount)
                        <x-slot:badge>{{ $unreadNotificationsCount }}</x-slot:badge>
                    @endif
                </x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">
                    Gelezen
                    @if ($readNotificationsCount)
                        <x-slot:badge>{{ $readNotificationsCount }}</x-slot:badge>
                    @endif
                </x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            @if (count($unreadNotifications))
                <x-ccm::tabs.tab-content :index="0" :no-margin="true">
                    <x-ccm::tables.table :no-margin="true">
                        <x-slot:thead>
                            <x-ccm::tables.th :first="true">
                                <x-ccm::forms.checkbox wire:model.live="checkAll"/>
                            </x-ccm::tables.th>
                            <x-ccm::tables.th>Bericht</x-ccm::tables.th>
                            <x-ccm::tables.th>Verzendtijd</x-ccm::tables.th>
                        </x-slot:thead>
                        <x-slot:tbody>
                            @foreach ($unreadNotifications AS $key => $_notification)
                                <x-ccm::tables.tr x-on:dblclick="$wire.showNotification('{{ $_notification->id }}')">
                                    <x-ccm::tables.td :first="true">
                                        <x-ccm::forms.checkbox wire:model.live="checkedNotifications"
                                                               value="{{ $_notification->id }}"/>
                                    </x-ccm::tables.td>
                                    <x-ccm::tables.td>
                                        {{ $_notification->data['title'] }}
                                    </x-ccm::tables.td>
                                    <x-ccm::tables.td>
                                        {{ $_notification->created_at->toDateTimeString() }}
                                    </x-ccm::tables.td>
                                </x-ccm::tables.tr>
                            @endforeach
                        </x-slot:tbody>
                    </x-ccm::tables.table>
                    <div class="p-4">
                        {{ $unreadNotifications->links() }}
                    </div>
                </x-ccm::tabs.tab-content>
            @else
                <x-ccm::tabs.tab-content :index="0">
                    <x-heroicon-s-check-circle class="w-8 h-8 text-green-500 inline"/>
                    Geen ongelezen berichten
                </x-ccm::tabs.tab-content>
            @endif
            <x-ccm::tabs.tab-content :index="1" :no-margin="true">
                <x-ccm::tables.table :no-margin="true">
                    <x-slot:thead>
                        <x-ccm::tables.th>Bericht</x-ccm::tables.th>
                        <x-ccm::tables.th>Verzendtijd</x-ccm::tables.th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($readNotifications AS $key => $_notification)
                            <x-ccm::tables.tr x-on:dblclick="$wire.showNotification('{{ $_notification->id }}')">
                                <x-ccm::tables.td>
                                    {{ $_notification->data['title'] }}
                                </x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    {{ $_notification->created_at->toDateTimeString() }}
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                </x-ccm::tables.table>

                <div class="p-4">
                    {{ $readNotifications->links() }}
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
    <x-ccm::layouts.modal width="2xl" :title="Arr::get($notification?->data, 'title')">
        {!! Arr::get($notification?->data, 'content') !!}
        <x-slot:buttons>
            <x-ccm::buttons.secundary x-on:click="show = false">
                Sluiten
            </x-ccm::buttons.secundary>
        </x-slot:buttons>
    </x-ccm::layouts.modal>
</div>
