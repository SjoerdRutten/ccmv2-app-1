<div>
    @if ($filter && !$readonly || ($readonly && $filter['active']))
        <div class="flex flex-row gap-2 items-center">
            @if (!$readonly)
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold rounded h-8 px-2 mt-2"
                        wire:confirm="Weet je zeker dat je dit criterium wilt verwijderen?"
                        wire:click="$parent.removeRule('{{ $index }}')"
                >
                    <x-heroicon-s-trash class="text-white h-4 w-4"/>
                </button>

                <x-ccm::forms.checkbox name="filter.active" wire:model.live="filter.active">
                </x-ccm::forms.checkbox>
            @endif

            <div class="flex flex-row gap-2 items-center grow {{ Arr::get($filter, 'active') ?: 'opacity-50' }}">
                <x-ccm::forms.select name="column"
                                     wire:model.live="filter.column"
                                     :grow="true"
                                     div-class="max-w-[25%]"
                                     :disabled="$readonly"
                >
                    <option>Kies kolom</option>
                    @foreach ($columns AS $column)
                        <option value="{{ $column->name }}">
                            {{ $column->label }}
                        </option>
                    @endforeach
                </x-ccm::forms.select>

                @if (Arr::get($filter, 'columnType') === 'target_group')
                    <x-target-group::column-types.target-group :filter="$filter"
                                                               :target-groups="$targetGroups"
                                                               :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'tag')
                    <x-target-group::column-types.tag :filter="$filter"
                                                      :tags="$tags"
                                                      :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'text')
                    <x-target-group::column-types.text :filter="$filter"
                                                       :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'text_array')
                    <x-target-group::column-types.text-array :filter="$filter"
                                                             :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'product_array')
                    <x-target-group::column-types.product-array :filter="$filter"
                                                                :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'integer_array')
                    <x-target-group::column-types.integer-array :filter="$filter"
                                                                :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'select')
                    <x-target-group::column-types.select :filter="$filter"
                                                         :options="$this->options()"
                                                         :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'boolean')
                    <x-target-group::column-types.boolean :filter="$filter"
                                                          :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'integer')
                    <x-target-group::column-types.integer :filter="$filter"
                                                          :disabled="$readonly"/>
                @elseif (Arr::get($filter, 'columnType') === 'date')
                    <x-target-group::column-types.date :filter="$filter"
                                                       :disabled="$readonly"/>
                @endif
            </div>
        </div>
        @if (Arr::get($filter, 'columnType') === 'target_group')
            @foreach ($elements AS $key => $element)
                @if (Arr::get($element, 'type') === 'block')
                    <livewire:target-group-selector::block
                            wire:model="elements.{{ $key }}"
                            wire:key="{{ hash('md5', serialize($elements)) }}"
                            :readonly="true"
                            index="{{ $key }}"
                    />
                @endif
            @endforeach
        @endif

    @endif
</div>
