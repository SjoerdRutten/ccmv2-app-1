<x-ccm::forms.input {{ $attributes->merge([
    'type' => 'time'
]) }}>
    {{ $slot }}
</x-ccm::forms.input>