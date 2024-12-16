@foreach ($fields AS $crmField)
    @if ($crmField->type === 'MEDIA')
        <h2 class="col-span-full font-bold">{{ $crmField->label ?: $crmField->name }}</h2>
        <div class="border border-gray-800 col-span-full grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded">
            <x-ccm::description-lists.element label="Optin">
                <x-ccm::forms.checkbox :name="$crmField.'_optin'"
                                       wire:model.live="form.data._{{ $crmField->name }}_optin"
                                       :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Optin timestamp">
                <x-ccm::forms.input type="datetime-local" :name="$crmField.'_optin_timestamp'"
                                    wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin_timestamp"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Confirmed optin">
                <x-ccm::forms.checkbox :name="$crmField.'_confirmed_optin'"
                                       wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin"
                                       :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Confirmed optin timestamp">
                <x-ccm::forms.input type="datetime-local" :name="$crmField.'_confirmed_optin_timestamp'"
                                    wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin_timestamp"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Optout">
                <x-ccm::forms.checkbox :name="$crmField.'_confirmed_optout'"
                                       wire:model.live="form.data._{{ $crmField->name }}_confirmed_optout"
                                       :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Optout timestamp">
                <x-ccm::forms.input type="datetime-local" :name="$crmField.'_optout_timestamp'"
                                    wire:model.live="form.data._{{ $crmField->name }}_optout_timestamp"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
        </div>
    @elseif ($crmField->type === 'EMAIL')
        <h2 class="col-span-full font-bold">{{ $crmField->label ?: $crmField->name }}</h2>
        <div class="border border-gray-800 col-span-full grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded">
            <x-ccm::description-lists.element label="E-mail" class="col-span-full">
                <x-ccm::forms.input :name="$crmField" wire:model.live="form.data.{{ $crmField->name }}"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Abuse">
                <x-ccm::forms.checkbox :name="$crmField.'_abuse'"
                                       wire:model.live="form.data._{{ $crmField->name }}_abuse"
                                       :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Abuse timestamp">
                <x-ccm::forms.input type="datetime-local" :name="$crmField.'_abuse_timestamp'"
                                    wire:model.live="form.data._{{ $crmField->name }}_abuse_timestamp"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Bounce reden">
                <x-ccm::forms.input :name="$crmField.'_bounce_reason'"
                                    wire:model.live="form.data._{{ $crmField->name }}_bounce_reason"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Bounce score">
                <x-ccm::forms.input type="number" :name="$crmField.'_bounce_score'"
                                    wire:model.live="form.data._{{ $crmField->name }}_bounce_score"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Bounce type">
                <x-ccm::forms.input :name="$crmField.'_bounce_type'"
                                    wire:model.live="form.data._{{ $crmField->name }}_bounce_type"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
            <x-ccm::description-lists.element label="Email type">
                <x-ccm::forms.input :name="$crmField.'_type'" wire:model.live="form.data._{{ $crmField->name }}_type"
                                    :disabled="!!$crmCard->id"/>
            </x-ccm::description-lists.element>
        </div>
    @else
        <x-ccm::description-lists.element :label="Str::replace('_', ' ', ($crmField->label ?: $crmField->name))"
                                          :title="$crmField->name">
            @if ($crmField->type === 'TEXTMICRO')
                <x-ccm::forms.input maxlength="4" :name="$crmField->name"
                                    wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'TEXTMINI')
                <x-ccm::forms.input maxlength="10" :name="$crmField->name"
                                    wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'TEXTSMALL')
                <x-ccm::forms.input maxlength="10" :name="$crmField->name"
                                    wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'TEXTMIDDLE')
                <x-ccm::forms.input maxlength="80" :name="$crmField->name"
                                    wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'TEXTBIG')
                <x-ccm::forms.textarea :name="$crmField->name" wire:model.live="form.data.{{ $crmField->name }}"
                                       :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'INT')
                <x-ccm::forms.input type="number" step="1" :name="$crmField->name"
                                    wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'DECIMAL')
                <x-ccm::forms.input type="number" step="0.01" :name="$crmField->name"
                                    wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'DATETIME')
                <x-ccm::forms.input type="datetime-local" :name="$crmField->name"
                                    wire:model.live="form.data.{{ $crmField->name }}" :disabled="$crmField->is_locked"/>
            @elseif (($crmField->type === 'CONSENT') || ($crmField->type === 'BOOLEAN'))
                <x-ccm::forms.checkbox :name="$crmField" wire:model.live="form.data.{{ $crmField->name }}"
                                       :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'BESTAND')
                TODO: Fieldtype BESTAND
            @endif
        </x-ccm::description-lists.element>
    @endif
@endforeach