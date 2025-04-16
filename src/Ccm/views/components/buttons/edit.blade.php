<x-ccm::buttons._icon_button {{ $attributes->merge(['icon' => 'heroicon-s-pencil']) }}>
    {{ $slot ?? 'Bewerken' }}
</x-ccm::buttons._icon_button>