<div class="border border-gray-300 bg-gray-200 p-2 my-1 flex flex-col relative gap-2 rounded">
    <x-ccm::forms.form>
        <x-ccm::forms.select label="Type regel" wire:model.live="{{ $key }}.type">
            <option></option>
            <option value="regex">Correctie m.b.v. patroonherkenning</option>
            <option value="ulcase">Correctie van hoofd- en kleine letters gebruik</option>
            <option value="trim">Verwijderen karakters en witruimte</option>
        </x-ccm::forms.select>
        <x-ccm::forms.select label="Patroon" wire:model.live="{{ $key }}.pattern">
            <option></option>
            <option value="date">Datum en tijd</option>
            <option value="email">E-mailadres</option>
            <option value="initials">Initialen</option>
            <option value="person-name">Persoonsnaam</option>
            <option value="city-name">Plaatsnaam</option>
            <option value="zipcode-be">Postcode, Belgisch</option>
            <option value="zipcode-de">Postcode, Duits</option>
            <option value="zipcode-nl">Postcode, Nederlands</option>
            <option value="street-name">Straatnaam</option>
            <option value="phone">Telefoonnummer</option>
            <option value="manual">Handmatige invoer van een patroon</option>
        </x-ccm::forms.select>
    </x-ccm::forms.form>
</div>