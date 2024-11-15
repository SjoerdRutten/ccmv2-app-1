<div class="border border-gray-300 bg-gray-200 p-2 my-1 flex flex-col relative gap-2 rounded"
     x-data="{ rule: @entangle('rule').live }">
    <x-ccm::forms.form>
        <x-ccm::forms.select label="Type regel" x-model="rule.type">
            <option></option>
            <option value="regex">Correctie m.b.v. patroonherkenning</option>
            <option value="ulcase">Correctie van hoofd- en kleine letters gebruik</option>
            <option value="trim">Verwijderen karakters en witruimte</option>
        </x-ccm::forms.select>
        <div x-show="rule.type === 'regex'">
            <x-ccm::forms.select label="Patroon" x-model="rule.corrector">
                <option></option>
                @foreach ($correctors['pattern'] AS $key => $corrector)
                    <option value="{{ $corrector::class }}">
                        {{ $corrector->name }}
                    </option>
                @endforeach
                {{--            <option value="date">Datum en tijd</option>--}}
                {{--            <option value="email">E-mailadres</option>--}}
                {{--            <option value="initials">Initialen</option>--}}
                {{--            <option value="person-name">Persoonsnaam</option>--}}
                {{--            <option value="city-name">Plaatsnaam</option>--}}
                {{--            <option value="zipcode-be">Postcode, Belgisch</option>--}}
                {{--            <option value="zipcode-de">Postcode, Duits</option>--}}
                {{--            <option value="zipcode-nl">Postcode, Nederlands</option>--}}
                {{--            <option value="street-name">Straatnaam</option>--}}
                {{--            <option value="phone">Telefoonnummer</option>--}}
                <option value="manual">Handmatige invoer van een patroon</option>
            </x-ccm::forms.select>
        </div>
    </x-ccm::forms.form>

    <div class="flex flex-row gap-4 mt-4">
        <a href="#"
           class="text-red-500"
           wire:confirm="Weet je zeker dat je deze regel wilt verwijderen ?"
           wire:click.prevent="removeRule('{{ $ruleType }}', '{{ $ruleKey }}')"
        >
            <x-heroicon-s-trash class="w-5 h-5 inline"/>
            Regel verwijderen
        </a>
    </div>
</div>