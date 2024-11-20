<form method="post" action="{{ route('forms::create-form-response', $form) }}">
    @@csrf
    @foreach ($fields AS $field)
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
                />
            @else
                @switch($crmField->type)
                    @case('TEXTMICRO')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="10"
                        />
                        @break

                    @case('TEXTMINI')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="40"
                        />
                        @break
                    @case('TEXTSMALL')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="80"
                        />
                        @break
                    @case('TEXTMIDDLE')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                max-length="255"
                        />
                        @break
                    @case('EMAIL')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                type="email"
                                max-length="255"
                        />
                        @break
                    @case('DECIMAL')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                type="number"
                                step="0.1"
                        />
                        @break
                    @case('INT')
                        <x-forms::form-fields.input
                                :field="$field"
                                :crm-field="$crmField"
                                type="number"
                                step="1"
                        />
                        @break
                    @case('TEXTBIG')
                        <x-forms::form-fields.textarea
                                :field="$field"
                                :crm-field="$crmField"
                        />
                        @break
                    @case('DATETIME')
                        <x-forms::form-fields.input
                                type="datetime-local"
                                :field="$field"
                                :crm-field="$crmField"
                        />
                        @break
                    @case('BOOLEAN')
                    @case('CONSENT')
                        <x-forms::form-fields.checkbox
                                :field="$field"
                                :crm-field="$crmField"
                        />
                        @break
                @endswitch
            @endif
        @endif
    @endforeach

    <x-forms::form-fields.submit/>

</form>