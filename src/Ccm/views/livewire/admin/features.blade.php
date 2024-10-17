<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CCM Features"></x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Actief</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($features AS $key => $feature)
                    <tr>
                        <x-ccm::tables.td :first="true">
                            {{ $feature['name'] }}
                        </x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::forms.checkbox
                                    wire:model.live="features.{{ $key }}.active"
                            />
                        </x-ccm::tables.td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>
    </div>
</div>
