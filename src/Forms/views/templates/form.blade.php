<form method="post" action="{{ route('cms::forms::create-form-response', $form, false) }}">
    @@csrf

    <x-forms::form-fields.errors/>

    @foreach ($fields AS $key => $field)
        @php
            $optin = false;
            if (\Illuminate\Support\Str::endsWith($field['crm_field_id'], '_optin')) {
                $optin = true;
                $field['crm_field_id'] = Str::substr($field['crm_field_id'], 0, -6);
            }

            $crmField = \Sellvation\CCMV2\CrmCards\Models\CrmField::find($field['crm_field_id'])
        @endphp


        @if ($crmField)
            @if ($optin)
                <x-forms::form-fields.checkbox
                        name="optin[]"
                        :id="$crmField->name.'_optin'"
                        :value="$crmField->name"
                        :field="$field"
                        :crm-field="$crmField"
                        class="form-field checkbox field-{{ $key }}"
                />
            @else
                @switch($crmField->type)
                    @case('TEXTMICRO')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="10"
                                class="form-field input textmicro field-{{ $key }}"
                        />
                        @break

                    @case('TEXTMINI')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="40"
                                class="form-field input textmini field-{{ $key }}"
                        />
                        @break
                    @case('TEXTSMALL')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="80"
                                class="form-field input textsmall field-{{ $key }}"
                        />
                        @break
                    @case('TEXTMIDDLE')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="255"
                                class="form-field input textmiddle field-{{ $key }}"
                        />
                        @break
                    @case('EMAIL')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                type="email"
                                max-length="255"
                                class="form-field input email field-{{ $key }}"
                        />
                        @break
                    @case('DECIMAL')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                type="number"
                                step="0.1"
                                class="form-field input decimal field-{{ $key }}"
                        />
                        @break
                    @case('INT')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                type="number"
                                step="1"
                                class="form-field input int field-{{ $key }}"
                        />
                        @break
                    @case('TEXTBIG')
                        <x-forms::form-fields.textarea
                                :field="$field"
                                :crm-field="$crmField"
                                class="form-field input textbig field-{{ $key }}"
                        />
                        @break
                    @case('DATETIME')
                        <x-forms::form-fields.input
                                type="datetime-local"
                                :field="$field"
                                :crm-field="$crmField"
                                class="form-field input datetime field-{{ $key }}"
                        />
                        @break
                    @case('BOOLEAN')
                    @case('CONSENT')
                        <x-forms::form-fields.checkbox
                                :field="$field"
                                :crm-field="$crmField"
                                class="form-field checkbox field-{{ $key }}"
                        />
                        @break
                @endswitch
            @endif
        @endif
    @endforeach

    <x-forms::form-fields.submit/>

</form>