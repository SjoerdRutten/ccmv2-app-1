<button
    {{
        $attributes->merge([
        'class' => 'block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600',
        ])
    }}
>
    @if ($slot->isEmpty())
        Opslaan
    @else
        {{ $slot }}
    @endif
</button>