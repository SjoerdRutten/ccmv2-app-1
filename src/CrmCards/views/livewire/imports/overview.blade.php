<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM kaart imports">
            <x-slot:actions>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Gebruiker</x-ccm::tables.th>
                <x-ccm::tables.th>Bestandsnaam</x-ccm::tables.th>
                <x-ccm::tables.th>Starttijd</x-ccm::tables.th>
                <x-ccm::tables.th>Eindtijd</x-ccm::tables.th>
                <x-ccm::tables.th>Status</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($crmCardImports AS $crmCardImport)
                    <x-ccm::tables.tr>
                        <x-ccm::tables.td>{{ $crmCardImport->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmCardImport->user->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmCardImport->file_name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmCardImport->started_at?->toDateTimeString('minute') }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $crmCardImport->finished_at?->toDateTimeString('minute') }}</x-ccm::tables.td>
                        <x-ccm::tables.td>
                            @switch($crmCardImport->status)
                                @case (0)
                                    In wachtrij
                                    @break
                                @case (1)
                                    Bezig
                                    @break
                                @case (2)
                                    Gereed
                                    @break
                            @endswitch

                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $crmCardImports->links() }}
    </div>
</div>
