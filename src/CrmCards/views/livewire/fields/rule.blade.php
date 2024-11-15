<div class="border border-gray-300 bg-gray-200 p-2 my-1 flex flex-col relative gap-2 rounded"
     x-data="{ rule: @entangle('rule') }">
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
            </x-ccm::forms.select>
        </div>
        <div x-show="rule.corrector.endsWith('CrmFieldCorrectorManual')">
            <x-ccm::forms.input x-model.blur="rule.regex">Vrij invoer patroon (regulier expressie)</x-ccm::forms.input>
            <x-ccm::forms.input x-model.blur="rule.replacePattern">Verwerkingsregel</x-ccm::forms.input>
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