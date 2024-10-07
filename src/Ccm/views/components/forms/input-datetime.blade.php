<x-ccm::forms.input {{ $attributes->merge([
    'type' => 'datetime-local'
]) }}>
    {{ $slot }}
</x-ccm::forms.input>