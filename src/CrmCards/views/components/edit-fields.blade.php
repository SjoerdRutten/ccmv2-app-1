@foreach ($fields AS $crmField)
    @if ($crmField->type === 'MEDIA')
        <div x-sort:item="{{ $crmField->id }}">
            <h2 class="col-span-full font-bold group flex justify-between">
                {{ $crmField->label ?: $crmField->name }}
                <x-heroicon-s-arrows-pointing-out class="w-4 h-4 hidden group-hover:inline" x-sort:handle/>
            </h2>
            <div class="border border-gray-800 col-span-full grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded">
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' optin' : '_'.$crmField->name.'_optin'">
                    <x-ccm::forms.checkbox :name="$crmField->name.'_optin'"
                                           wire:model.live="form.data._{{ $crmField->name }}_optin"
                                           :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' optin timestamp': '_'.$crmField->name.'_optin_timestamp'">
                    <x-ccm::forms.input type="datetime-local"
                                        :name="$crmField->name.'_optin_timestamp'"
                                        wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin_timestamp"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' confirmed optin': '_'.$crmField->name.'_confirmed_optin'">
                    <x-ccm::forms.checkbox :name="$crmField->name.'_confirmed_optin'"
                                           wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin"
                                           :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' confirmed optin timestamp': '_'.$crmField->name.'_confirmed_optin_timestamp'">
                    <x-ccm::forms.input type="datetime-local"
                                        :name="$crmField->name.'_confirmed_optin_timestamp'"
                                        wire:model.live="form.data._{{ $crmField->name }}_confirmed_optin_timestamp"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' optout': '_'.$crmField->name.'_optout'">
                    <x-ccm::forms.checkbox :name="$crmField->name.'_optout'"
                                           wire:model.live="form.data._{{ $crmField->name }}_optout"
                                           :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' optout timestamp': '_'.$crmField->name.'_optout_timestamp'">
                    <x-ccm::forms.input type="datetime-local"
                                        :name="$crmField->name.'_optout_timestamp'"
                                        wire:model.live="form.data._{{ $crmField->name }}_optout_timestamp"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
            </div>
        </div>
    @elseif ($crmField->type === 'EMAIL')
        <div x-sort:item="{{ $crmField->id }}">
            <h2 class="col-span-full font-bold group flex justify-between">
                {{ $crmField->label ?: $crmField->name }}
                <x-heroicon-s-arrows-pointing-out class="w-4 h-4 hidden group-hover:inline" x-sort:handle/>
            </h2>
            <div class="border border-gray-800 col-span-full grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded">
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' e-mailadres': $crmField->name"
                        class="col-span-full">
                    <x-ccm::forms.input :name="$crmField->name"
                                        wire:model.live="form.data.{{ $crmField->name }}"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' abuse': '_'.$crmField->name.'_abuse'">
                    <x-ccm::forms.checkbox :name="$crmField->name.'_abuse'"
                                           wire:model.live="form.data._{{ $crmField->name }}_abuse"
                                           :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' abuse timestamp': '_'.$crmField->name.'_abuse_timestamp'">
                    <x-ccm::forms.input type="datetime-local"
                                        :name="$crmField->name.'_abuse_timestamp'"
                                        wire:model.live="form.data._{{ $crmField->name }}_abuse_timestamp"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' bounce reason': '_'.$crmField->name.'_bounce_reason'">
                    <x-ccm::forms.input :name="$crmField->name.'_bounce_reason'"
                                        wire:model.live="form.data._{{ $crmField->name }}_bounce_reason"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' bounce score': '_'.$crmField->name.'_bounce_score'">
                    <x-ccm::forms.input type="number"
                                        :name="$crmField->name.'_bounce_score'"
                                        wire:model.live="form.data._{{ $crmField->name }}_bounce_score"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' bounce type': '_'.$crmField->name.'_bounce_type'">
                    <x-ccm::forms.input :name="$crmField->name.'_bounce_type'"
                                        wire:model.live="form.data._{{ $crmField->name }}_bounce_type"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
                <x-ccm::description-lists.element
                        :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)).' email type': '_'.$crmField->name.'_email_type'">
                    <x-ccm::forms.input :name="$crmField->name.'_type'"
                                        wire:model.live="form.data._{{ $crmField->name }}_type"
                                        :disabled="!!$crmCard->id"/>
                </x-ccm::description-lists.element>
            </div>
        </div>
    @else
        <x-ccm::description-lists.element
                :label="$showLabel === 'label' ? Str::replace('_', ' ', ($crmField->label ?: $crmField->name)) : $crmField->name"
                :title="$crmField->name"
                :crm-field="$crmField"
        >
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
                <x-ccm::forms.checkbox :name="$crmField->name"
                                       wire:model.live="form.data.{{ $crmField->name }}"
                                       :disabled="$crmField->is_locked"/>
            @elseif ($crmField->type === 'BESTAND')
                TODO: Fieldtype BESTAND
            @endif
        </x-ccm::description-lists.element>
    @endif
@endforeach