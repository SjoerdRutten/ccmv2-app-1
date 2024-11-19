<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Formulieren">
            <div class="flex gap-4">
                {{--                <x-ccm::forms.select label="Rubriek" wire:model.live="filter.email_category_id">--}}
                {{--                    <option></option>--}}
                {{--                    @foreach ($emailCategories AS $category)--}}
                {{--                        <option value="{{ $category->id }}">--}}
                {{--                            {{ $category->name }}--}}
                {{--                        </option>--}}
                {{--                    @endforeach--}}
                {{--                </x-ccm::forms.select>--}}
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
                <x-ccm::tables.th>Aantal responses</x-ccm::tables.th>
                <x-ccm::tables.th>Laatste response</x-ccm::tables.th>
                <x-ccm::tables.th :link="true">Acties</x-ccm::tables.th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($forms AS $key => $form)
                    <x-ccm::tables.tr :route="route('forms::edit', $form)">
                        <x-ccm::tables.td :first="true">{{ $form->id }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $form->name }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $form->description }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $form->formResponses()->count() }}</x-ccm::tables.td>
                        <x-ccm::tables.td>{{ $form->formResponses()->latest()->first()?->createdAt() }}</x-ccm::tables.td>
                        <x-ccm::tables.td :link="true">
                            <x-ccm::tables.edit-link :href="route('forms::edit', $form)"/>
                        </x-ccm::tables.td>
                    </x-ccm::tables.tr>
                @endforeach
            </x-slot:tbody>
        </x-ccm::tables.table>

        {{ $forms->links() }}
    </div>
</div>
