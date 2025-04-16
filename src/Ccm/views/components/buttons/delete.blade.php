<x-ccm::buttons._icon_button {{ $attributes->merge(['icon' => 'heroicon-s-trash', 'class' => 'text-red-500']) }}>
    {{ $slot ?? 'Verwijderen' }}
</x-ccm::buttons._icon_button>