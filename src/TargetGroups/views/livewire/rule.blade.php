<div>
    @if ($filterTmp && !$readonly || ($readonly && $filterTmp['active']))
        <div class="flex flex-row gap-2 items-center">
            @if (!$readonly)
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold rounded h-8 px-2 mt-2"
                        wire:confirm="Weet je zeker dat je dit criterium wilt verwijderen?"
                        wire:click="$parent.removeRule('{{ $index }}')"
                >
                    <x-heroicon-s-trash class="text-white h-4 w-4"/>
                </button>

                <x-ccm::forms.checkbox name="filterTmp.active" wire:model.live="filterTmp.active">
                </x-ccm::forms.checkbox>
            @endif

            <div class="flex flex-row gap-2 items-center grow {{ Arr::get($filterTmp, 'active') ?: 'opacity-50' }}">
                <x-ccm::forms.select name="column"
                                     wire:model.live="filterTmp.column"
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

                @if (Arr::get($filterTmp, 'columnType') === 'target_group')
                    <x-target-group::column-types.target-group :filter="$filterTmp"
                                                               :target-groups="$targetGroups"
                                                               :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'tag')
                    <x-target-group::column-types.tag :filter="$filterTmp"
                                                      :tags="$tags"
                                                      :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'text')
                    <x-target-group::column-types.text :filter="$filterTmp"
                                                       :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'text_array')
                    <x-target-group::column-types.text-array :filter="$filterTmp"
                                                             :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'product_array')
                    <x-target-group::column-types.product-array :filter="$filterTmp"
                                                                :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'integer_array')
                    <x-target-group::column-types.integer-array :filter="$filterTmp"
                                                                :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'select')
                    <x-target-group::column-types.select :filter="$filterTmp"
                                                         :options="$this->options()"
                                                         :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'boolean')
                    <x-target-group::column-types.boolean :filter="$filterTmp"
                                                          :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'integer')
                    <x-target-group::column-types.integer :filter="$filterTmp"
                                                          :disabled="$readonly"/>
                @elseif ((Arr::get($filterTmp, 'columnType') === 'float') || (Arr::get($filterTmp, 'columnType') === 'price'))
                    <x-target-group::column-types.float :filter="$filterTmp"
                                                        :disabled="$readonly"/>
                @elseif (Arr::get($filterTmp, 'columnType') === 'date')
                    <x-target-group::column-types.date :filter="$filterTmp"
                                                       :disabled="$readonly"/>
                @endif
            </div>
        </div>
        @if (Arr::get($filterTmp, 'columnType') === 'target_group')
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
