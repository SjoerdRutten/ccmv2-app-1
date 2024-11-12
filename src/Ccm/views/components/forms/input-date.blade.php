<x-ccm::forms.input {{ $attributes->merge([
    'type' => 'text'
]) }}>
    {{ $slot }}
</x-ccm::forms.input>