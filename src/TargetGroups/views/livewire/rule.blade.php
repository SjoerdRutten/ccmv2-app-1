<div class="flex flex-row gap-2 items-center">
    @if ($filter)
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold rounded h-8 px-2 mt-2"
                wire:confirm="Weet je zeker dat je dit criterium wilt verwijderen ?"
                wire:click="$parent.removeElement('{{ $filter['index'] }}')"
        >
            <x-heroicon-s-trash class="text-white h-4 w-4"/>
        </button>

        <x-ccm::forms.checkbox name="filter.active" wire:model.live="filter.active">
        </x-ccm::forms.checkbox>

        <div class="flex flex-row gap-2 items-center grow {{ Arr::get($filter, 'active') ?: 'opacity-50' }}">
            <x-ccm::forms.select name="column" wire:model.live="filter.column" :grow="true" div-class="max-w-[25%]">
                <option>Kies kolom</option>
                @foreach ($columns AS $column)
                    <option value="{{ $column->name }}">
                        {{ $column->label }}
                    </option>
                @endforeach
            </x-ccm::forms.select>

            @if (Arr::get($filter, 'columnType') === 'target_group')
                <x-target-group::column-types.target-group :filter="$filter" :target-groups="$targetGroups"/>
            @elseif (Arr::get($filter, 'columnType') === 'tag')
                <x-target-group::column-types.tag :filter="$filter" :tags="$tags"/>
            @elseif (Arr::get($filter, 'columnType') === 'text')
                <x-target-group::column-types.text :filter="$filter"/>
            @elseif (Arr::get($filter, 'columnType') === 'text_array')
                <x-target-group::column-types.text-array :filter="$filter"/>
            @elseif (Arr::get($filter, 'columnType') === 'product_array')
                <x-target-group::column-types.product-array :filter="$filter"/>
            @elseif (Arr::get($filter, 'columnType') === 'integer_array')
                <x-target-group::column-types.integer-array :filter="$filter"/>
            @elseif (Arr::get($filter, 'columnType') === 'select')
                <x-target-group::column-types.select :filter="$filter" :options="$this->options()"/>
            @elseif (Arr::get($filter, 'columnType') === 'boolean')
                <x-target-group::column-types.boolean :filter="$filter"/>
            @elseif (Arr::get($filter, 'columnType') === 'integer')
                <x-target-group::column-types.integer :filter="$filter"/>
            @elseif (Arr::get($filter, 'columnType') === 'date')
                <x-target-group::column-types.date :filter="$filter"/>
            @endif
        </div>
    @endif
</div>

