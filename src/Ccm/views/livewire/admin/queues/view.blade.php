<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro :title="'Wachtrij '.$queue.' ('.$size.')'">
            <x-slot:actions>
                {{--                <x-ccm::buttons.add route="admin::environments::add">Omgeving toevoegen</x-ccm::buttons.add>--}}
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th>Job</x-ccm::tables.th>
                <x-ccm::tables.th>Attempts</x-ccm::tables.th>
                <x-ccm::tables.th>Status</x-ccm::tables.th>
                <x-ccm::tables.th>Details</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($jobs AS $job)
                    <x-ccm::tables.tr>
                        <x-ccm::tables.td>{{ $job['displayName'] }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $job['attempts'] }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ Arr::get($job, 'status') ?: 'queued' }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            <pre>{{ json_encode($job['data'], JSON_PRETTY_PRINT) }}</pre>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
