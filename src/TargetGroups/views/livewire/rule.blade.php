<div class="my-4 flex flex-row gap-4">
    @if ($filter)
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                wire:click="$parent.removeElement('{{ $filter['index'] }}')"
        >

            X
        </button>
        <select name="column" wire:model.live="filter.column" class="max-w-[25%]">
            <option>Kies kolom</option>
            @foreach ($columns AS $column)
                <option value="{{ $column->name }}">
                    @if (empty($column->label))
                        {{ $column->name }}
                    @else
                        {{ $column->label }}
                    @endif
                </option>
            @endforeach
        </select>

        @if (Arr::get($filter, 'columnType') === 'text')
            <select name="operator" wire:model.live="filter.operator">
                <option value="">Kies operator</option>
                <option value="con">Bevat</option>
                <option value="dnc">Bevat niet</option>
                <option value="sw">Begint met</option>
                <option value="snw">Begint niet met</option>
                <option value="ew">Eindigt op</option>
                <option value="enw">Eindigt niet op</option>
            </select>
            <input type="text" wire:model.blur="filter.value"/>
        @elseif (Arr::get($filter, 'columnType') === 'text_array')
            <select name="operator" wire:model.live="filter.operator">
                <option value="">Kies operator</option>
                <option value="con">Bevat</option>
                <option value="dnc">Bevat niet</option>
            </select>
            <input type="text" wire:model.blur="filter.value"/>
        @elseif (Arr::get($filter, 'columnType') === 'select')
            <select name="operator" wire:model.live="filter.operator">
                <option value="">Kies operator</option>
                <option value="con">Bevat</option>
                <option value="dnc">Bevat niet</option>
            </select>

            <select name="value" wire:model.live="filter.value" multiple>
                <option></option>
                @foreach ($this->options() AS $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
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
            <select name="operator" wire:model.live="filter.operator">
                <option value="">Kies operator</option>
                <option value="gt">Groter dan</option>
                <option value="gte">Groter of gelijk</option>
                <option value="lt">Kleiner dan</option>
                <option value="lte">Kleiner of gelijk</option>
                <option value="eq">Gelijk aan</option>
                <option value="ne">Niet gelijk aan</option>
                <option value="between">Tussen</option>
            </select>

            @if (Arr::get($filter, 'operator'))
                @if (Arr::get($filter, 'operator') === 'between')
                    <input type="number" step="1" wire:model.blur="filter.value.from"/>
                    <input type="number" step="1" wire:model.blur="filter.value.to"/>
                @else
                    <input type="number" step="1" wire:model.blur="filter.value"/>
                @endif
            @endif
        @elseif (Arr::get($filter, 'columnType') === 'date')
            <select name="operator" wire:model.live="filter.operator">
                <option value="">Kies operator</option>
                <option value="gt">Groter dan</option>
                <option value="gte">Groter of gelijk</option>
                <option value="lt">Kleiner dan</option>
                <option value="lte">Kleiner of gelijk</option>
                <option value="eq">Gelijk aan</option>
                <option value="ne">Niet gelijk aan</option>
                <option value="between">Tussen</option>
            </select>

            @if (Arr::get($filter, 'operator'))
                @if (Arr::get($filter, 'operator') === 'between')
                    <input type="date" wire:model.blur="filter.value.from"/>
                    <input type="date" wire:model.blur="filter.value.to"/>
                @else
                    <input type="date" wire:model.blur="filter.value"/>
                @endif
            @endif
        @endif
    @endif
</div>

