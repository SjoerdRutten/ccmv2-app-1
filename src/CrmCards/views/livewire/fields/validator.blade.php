<div class="border border-gray-300 bg-gray-200 p-2 my-1 flex flex-col relative gap-2 rounded"
     x-data="{ validator: @entangle('validator') }">
    <x-ccm::forms.form>

        <x-ccm::forms.select label="Type regel" x-model="validator.type">
            <option></option>
            @if (Arr::get($validators, 'extensions'))
                <option value="extensions">Correctie via extensie</option>
            @endif
            <option value="characters">Controle op aantal karakters</option>
            <option value="dates">Controle van datums</option>
            <option value="numbers">Controle van getallen</option>
            <option value="texts">Controle van tekst</option>
            <option value="patterns">Controle m.b.v. patroonherkenning</option>
        </x-ccm::forms.select>
        <div x-show="validator.type === 'characters'">
            <x-ccm::forms.select label="Karakter regels" x-model="validator.rule">
                <option></option>
                @foreach ($validators['characters'] AS $key => $validator)
                    <option
                            value="{{ $validator::class }}"
                            data-hasValue="{{ $validator->hasValue ? 1 : 0 }}"
                    >
                        {{ $validator->name }}
                    </option>
                @endforeach
            </x-ccm::forms.select>
            <x-ccm::forms.input x-model="validator.value">Aantal karakters</x-ccm::forms.input>
        </div>
        <div x-show="validator.type === 'dates'">
            <x-ccm::forms.select label="Datum regels" x-model="validator.rule">
                <option></option>
                @foreach ($validators['dates'] AS $key => $validator)
                    <option
                            value="{{ $validator::class }}"
                            data-hasValue="{{ $validator->hasValue ? 1 : 0 }}"
                    >
                        {{ $validator->name }}
                    </option>
                @endforeach
            </x-ccm::forms.select>
            <x-ccm::forms.input x-model="validator.value">Datum</x-ccm::forms.input>
        </div>
        <div x-show="validator.type === 'numbers'">
            <x-ccm::forms.select label="Getal regels" x-model="validator.rule">
                <option></option>
                @foreach ($validators['numbers'] AS $key => $validator)
                    <option
                            value="{{ $validator::class }}"
                            data-hasValue="{{ $validator->hasValue ? 1 : 0 }}"
                    >
                        {{ $validator->name }}
                    </option>
                @endforeach
            </x-ccm::forms.select>
            <x-ccm::forms.input x-model="validator.value">Waarde</x-ccm::forms.input>
        </div>
        <div x-show="validator.type === 'texts'">
            <x-ccm::forms.select label="Tekst regels" x-model="validator.rule">
                <option></option>
                @foreach ($validators['texts'] AS $key => $validator)
                    <option
                            value="{{ $validator::class }}"
                            data-hasValue="{{ $validator->hasValue ? 1 : 0 }}"
                    >
                        {{ $validator->name }}
                    </option>
                @endforeach
            </x-ccm::forms.select>
            <x-ccm::forms.input x-model="validator.value">Waarde</x-ccm::forms.input>
        </div>
        <div x-show="validator.type === 'patterns'">
            <x-ccm::forms.select label="Patroon" x-model="validator.rule">
                <option></option>
                @foreach ($validators['patterns'] AS $key => $validator)
                    <option
                            value="{{ $validator::class }}"
                            data-hasValue="{{ $validator->hasValue ? 1 : 0 }}"
                    >
                        {{ $validator->name }}
                    </option>
                @endforeach
            </x-ccm::forms.select>
            <x-ccm::forms.input x-model="validator.value">Waarde</x-ccm::forms.input>
        </div>

    </x-ccm::forms.form>

    <div class="flex flex-row gap-4 mt-4">
        <a href="#"
           class="text-red-500"
           wire:confirm="Weet je zeker dat je deze validatieregel wilt verwijderen ?"
           wire:click.prevent="removeValidator('{{ $validatorKey }}')"
        >
            <x-heroicon-s-trash class="w-5 h-5 inline"/>
            Regel verwijderen
        </a>
    </div>
</div>