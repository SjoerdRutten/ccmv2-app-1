<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="CRM kaarten">
            <div class="flex gap-4">
                <div class="w-1/4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoeken</x-ccm::forms.input>
                </div>
            </div>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                @foreach ($crmFields AS $crmField)
                    <x-ccm::tables.th>
                        {{ $crmField->name }}
                    </x-ccm::tables.th>
                @endforeach
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($crmCards AS $key => $card)
                    <tr>
                        <x-ccm::tables.td :first="true">{{ $card->crm_id }}</x-ccm::tables.td>
                        @foreach ($crmFields AS $crmField)
                            <x-ccm::tables.td>{{ \Illuminate\Support\Arr::get($card->data, $crmField->name) }}</x-ccm::tables.td>
                        @endforeach
                        <x-ccm::tables.td :link="true">
{{--                            <x-ccm::tables.edit-link :href="route('crm-cards::fields::edit', $crmField['id'])" />--}}
                        </x-ccm::tables.td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $crmCards->links() }}
    </div>
</div>
