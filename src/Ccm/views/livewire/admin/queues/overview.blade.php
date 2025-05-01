<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Wachtrijen">
            <x-slot:actions>
                {{--                <x-ccm::buttons.add route="admin::environments::add">Omgeving toevoegen</x-ccm::buttons.add>--}}
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Jobs in wachtrij</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($queues AS $queueName => $queue)
                    <x-ccm::tables.tr>
                        <x-ccm::tables.td :first="true">{{ $queueName }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $queue['count'] }}</x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
