<div>
    <x-forms::form-fields.label :field="$field" :crm-field="$crmField"/>

    <textarea name="{{ $crmField->name }}" id="{{ $crmField->name }}" {{ $field['required'] ? 'required' : '' }} />
</div>