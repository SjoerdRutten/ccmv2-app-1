<x-ccm::buttons.primary href="{{ ($route ?? false) ? route($route) : '#' }}" icon="heroicon-s-plus">
    {{ $slot }}
</x-ccm::buttons.primary>