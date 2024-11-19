<x-ccm::buttons.primary href="{{ ($route ?? false) ? route($route) : '#' }}" icon="heroicon-s-plus" {{ $attributes }}>
    {{ $slot }}
</x-ccm::buttons.primary>