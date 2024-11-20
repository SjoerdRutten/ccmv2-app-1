<div>
    <x-forms::form-fields.label :field="$field" :crm-field="$crmField"/>


    <input type="{{ $type ?? 'text' }}" name="{{ $crmField->name }}" id="{{ $crmField->name }}"
           value="@php echo "{{ old('".$crmField->name."') }}" @endphp"
           {{ $field['required'] ? 'required' : '' }} @if (($type ?? 'text')=== 'number') step="{{ $step ?? 1 }}"
           @else maxlength="{{ $maxLength ?? 80 }}" @endif />
</div>