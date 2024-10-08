<x-ccm::forms.input {{ $attributes->merge([
    'type' => 'date'
]) }}>
    {{ $slot }}
</x-ccm::forms.input>