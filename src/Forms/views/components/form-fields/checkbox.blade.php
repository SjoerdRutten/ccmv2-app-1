<div>
    <x-forms::form-fields.label :field="$field" :crm-field="$crmField"/>

    <input type="checkbox"
           name="{{ $name ?? $crmField->name }}" id="{{ $crmField->name }}"
            {{ $field['required'] ? 'required' : '' }}
    />
</div>