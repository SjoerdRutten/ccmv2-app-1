<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Doelgroep selecties">
            Introductietekst over doelgroep selecties

            <x-slot:actions>
                <x-ccm::buttons.add route="target-groups::form">Doelgroep selectie toevoegen</x-ccm::buttons.add>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Creatietijd</x-ccm::tables.th>
                <x-ccm::tables.th>Updatetijd</x-ccm::tables.th>
                <x-ccm::tables.th>Aantal resultaten</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Bewerk</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($this->targetGroups AS $targetGroup)
                    <tr>
                        <x-ccm::tables.td :first="true">{{ $targetGroup->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $targetGroup->created_at->toDateTimeString() }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $targetGroup->updated_at->toDateTimeString() }}</x-ccm::tables.td>
                        <x-ccm::tables.td>??</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <a href="{{ route('target-groups::form', $targetGroup) }}" class="text-indigo-600 hover:text-indigo-900">Bewerk<span class="sr-only">, {{ $targetGroup->name }}</span></a>
                        </x-ccm::tables.td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
