<x-ccm::forms.form>
    <x-ccm::forms.select>
        <option></option>
        @foreach ($crmFields AS $crmField)
            <option value="{{ $crmField->id }}">
                {{ $crmField->label }}
            </option>
        @endforeach
    </x-ccm::forms.select>
</x-ccm::forms.form>