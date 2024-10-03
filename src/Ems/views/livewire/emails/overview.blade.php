<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mails">
            <div class="flex gap-4">
                <x-ccm::forms.input
                        name="filterQ"
                        wire:model.live.debounce="filter.q"
                >Zoeken
                </x-ccm::forms.input>
            </div>
        </x-ccm::pages.intro>
        <x-ccm::tables.table>
            <x-slot:thead>
                <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                <x-ccm::tables.th>Naam</x-ccm::tables.th>
                <x-ccm::tables.th>Omschrijving</x-ccm::tables.th>
                <x-ccm::tables.th>Onderwerp</x-ccm::tables.th>
                <x-ccm::tables.th>Laatste update</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($emails AS $key => $email)
                    <tr x-on:dblclick="document.location.href = '{{ route('ems::emails::edit', $email) }}'">
                        <x-ccm::tables.td :first="true">{{ $email->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $email->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $email->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $email->subject }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $email->updated_at }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('ems::emails::edit', $email)"/>
                        </x-ccm::tables.td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $emails->links() }}
    </div>
</div>
