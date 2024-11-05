<div class="flex flex-row gap-2 items-center">
    @if ($filter)
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold rounded h-8 px-2 mt-2"
                wire:confirm="Weet je zeker dat je dit criterium wilt verwijderen ?"
                wire:click="$parent.removeElement('{{ $filter['index'] }}')"
        >
            <x-heroicon-s-trash class="text-white h-4 w-4"/>
        </button>

        <x-ccm::forms.select name="column" wire:model.live="filter.column" :grow="true" div-class="max-w-[25%]">
            <option>Kies kolom</option>
            @foreach ($columns AS $column)
                <option value="{{ $column->name }}">
                    {{ $column->label }}
                </option>
            @endforeach
        </x-ccm::forms.select>

        @if (Arr::get($filter, 'columnType') === 'target_group')
            <x-ccm::forms.select name="value" wire:model.live="filter.value">
                <option value="">Selecteer doelgroep</option>
                @foreach ($targetGroup AS $targetGroup)
                    <option value="{{ $targetGroup->id }}">
                        {{ $targetGroup->name }}
                    </option>
                @endforeach
            </x-ccm::forms.select>
        @elseif (Arr::get($filter, 'columnType') === 'tag')
            <x-ccm::forms.multiple-select name="value" wire:model.live="filter.value">
                <option value="">Selecteer kenmerk</option>
                @foreach ($tags AS $tag)
                    <option value="{{ $tag->id }}">
                        {{ $tag->name }}
                    </option>
                @endforeach
            </x-ccm::forms.multiple-select>
        @elseif (Arr::get($filter, 'columnType') === 'text')
            <x-ccm::forms.select name="operator" wire:model.live="filter.operator">
                <option value="">Kies operator</option>
                <option value="con">Bevat</option>
                <option value="dnc">Bevat niet</option>
                <option value="sw">Begint met</option>
                <option value="snw">Begint niet met</option>
                <option value="ew">Eindigt op</option>
                <option value="enw">Eindigt niet op</option>
                <option value="eq">Gelijk aan</option>
                <option value="eqm">Gelijk aan 1 van</option>
                <option value="neqm">Niet gelijk aan 1 van</option>
            </x-ccm::forms.select>
            <x-ccm::forms.input name="filter.value" wire:model.blur="filter.value" :grow="true"/>
        @elseif (Arr::get($filter, 'columnType') === 'text_array')
            <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
                <option value="">Kies operator</option>
                <option value="con">Bevat</option>
                <option value="dnc">Bevat niet</option>
                <option value="eqm">Gelijk aan 1 van</option>
                <option value="neqm">Niet gelijk aan 1 van</option>
            </x-ccm::forms.select>
            @if (($filter['operator'] === 'eqm') || ($filter['operator'] === 'neqm'))
                <x-ccm::forms.multiple-select name="filter.value" :grow="true"></x-ccm::forms.multiple-select>
            @else
                <x-ccm::forms.input name="filter.value{{ $filter['id'] }}" wire:model.blur="filter.value" :grow="true"/>
            @endif
        @elseif (Arr::get($filter, 'columnType') === 'product_array')
            <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
                <option value="">Kies operator</option>
                <option value="con">Bevat product</option>
                <option value="dnc">Bevat niet product</option>
            </x-ccm::forms.select>
            <div>0 Producten geselecteerd</div>
            <div x-data="{ show: true }">
                <x-ccm::buttons.primary x-on:click="show = true">Producten selecteren</x-ccm::buttons.primary>
                <x-ccm::layouts.modal
                        title="Producten selecteren"
                        width="2xl"
                >
                    <x-ccm::forms.input
                            placeholder="Zoek producten op naam, sku of ean"
                            class="mb-4"
                    />

                    <div class="flex gap-4">
                        <div class="w-[48%] h-[200px] overflow-auto border border-gray-300 rounded">
                            LINKS
                        </div>
                        <div class="grow">
                            >
                        </div>
                        <div class="w-[48%] h-[200px] overflow-auto border border-gray-300 rounded">
                            RECHTS
                        </div>
                    </div>

                    <x-slot:buttons>
                        <x-ccm::buttons.secundary x-on:click="show = false">
                            Sluiten
                        </x-ccm::buttons.secundary>
                    </x-slot:buttons>
                </x-ccm::layouts.modal>
            </div>
        @elseif (Arr::get($filter, 'columnType') === 'integer_array')
            <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
                <option value="">Kies operator</option>
                <option value="eqm">Gelijk aan 1 van</option>
                <option value="neqm">Niet gelijk aan 1 van</option>
            </x-ccm::forms.select>
            <x-ccm::forms.multiple-select name="filter.value" :grow="true"></x-ccm::forms.multiple-select>
        @elseif (Arr::get($filter, 'columnType') === 'select')
            <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
                <option value="">Kies operator</option>
                <option value="con">Bevat</option>
                <option value="dnc">Bevat niet</option>
            </x-ccm::forms.select>

            <x-ccm::forms.select name="value" wire:model.live="filter.value">
                <option></option>
                @foreach ($this->options() AS $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </x-ccm::forms.select>
        @elseif (Arr::get($filter, 'columnType') === 'boolean')
            <input type="hidden" wire:model="filter.operator"/>
            <label>
                <input type="radio" name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}" value="1"
                       wire:model.live="filter.value"/>
                Ja
            </label>
            <label>
                <input type="radio" name="filter{{ Arr::get($filter, 'column') }}{{ $uniq }}" value="0"
                       wire:model.live="filter.value"/>
                Nee
            </label>
        @elseif (Arr::get($filter, 'columnType') === 'integer')
            <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
                <option value="">Kies operator</option>
                <option value="gt">Groter dan</option>
                <option value="gte">Groter of gelijk</option>
                <option value="lt">Kleiner dan</option>
                <option value="lte">Kleiner of gelijk</option>
                <option value="between">Tussen</option>
                <option value="eq">Gelijk aan</option>
                <option value="ne">Niet gelijk aan</option>
                <option value="eqm">Gelijk aan 1 van</option>
                <option value="neqm">Niet gelijk aan 1 van</option>
            </x-ccm::forms.select>

            @if (Arr::get($filter, 'operator'))
                @if (Arr::get($filter, 'operator') === 'between')
                    <x-ccm::forms.input type="text" step="1" name="filter.from" wire:model.blur="filter.from"/>
                    <x-ccm::forms.input type="text" step="1" name="filter.to" wire:model.blur="filter.to"/>
                @else
                    <x-ccm::forms.input type="text"
                                        step="1"
                                        name="filter.value"
                                        wire:model.blur="filter.value"
                                        :grow="true"/>
                @endif
            @endif
        @elseif (Arr::get($filter, 'columnType') === 'date')
            <x-ccm::forms.select name="operator" wire:model.live="filter.operator" class="w-[170px]">
                <option value="">Kies operator</option>
                <option value="gt">Groter dan</option>
                <option value="gte">Groter of gelijk</option>
                <option value="lt">Kleiner dan</option>
                <option value="lte">Kleiner of gelijk</option>
                <option value="eq">Gelijk aan</option>
                <option value="ne">Niet gelijk aan</option>
                <option value="between">Tussen</option>
            </x-ccm::forms.select>

            @if (Arr::get($filter, 'operator'))
                @if (Arr::get($filter, 'operator') === 'between')
                    <x-ccm::forms.input-date name="filter.from" wire:model.blur="filter.from"/>
                    <x-ccm::forms.input-date name="filter.to" wire:model.blur="filter.to"/>
                @else
                    <x-ccm::forms.input-date name="filter.value" wire:model.blur="filter.value"/>
                @endif
            @endif
        @endif
    @endif
</div>

