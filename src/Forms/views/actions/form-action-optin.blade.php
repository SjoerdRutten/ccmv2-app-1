<x-ccm::forms.form>
    <x-ccm::forms.select
            wire:model="editForm.async_actions.{{ $key }}.params.crm_field_id"
            label="CRM Veld"
    >
        <option></option>
        @foreach ($crmFields AS $crmField)
            <option value="{{ $crmField->id }}">
                {{ $crmField->label ?: $crmField->name }}
            </option>
        @endforeach
    </x-ccm::forms.select>
</x-ccm::forms.form>