<div>
    <x-forms::form-fields.label :field="$field" :crm-field="$crmField" :id="$id ?? $crmField->name"/>

    <input type="checkbox"
           name="{{ $name ?? $crmField->name }}" id="{{ $id ?? $crmField->name }}" value="{{ $value ?? 1 }}"
            {{ $field['required'] ? 'required' : '' }}
    />
</div>