@foreach ($fields AS $key => $field)
    @if (Arr::get($field, 'type') === 'textarea')
        <x-ccm::forms.textarea
                wire:model="form.settings.{{ Arr::get($field, 'key') }}">
            {{ Arr::get($field, 'label') }}
        </x-ccm::forms.textarea>
    @elseif (Arr::get($field, 'type') === 'text')
        <x-ccm::forms.input
                wire:model="form.settings.{{ Arr::get($field, 'key') }}">
            {{ Arr::get($field, 'label') }}
        </x-ccm::forms.input>
    @elseif (Arr::get($field, 'type') === 'number')
        <x-ccm::forms.input
                type="number"
                wire:model="form.settings.{{ Arr::get($field, 'key') }}">
            {{ Arr::get($field, 'label') }}
        </x-ccm::forms.input>
    @endif
@endforeach