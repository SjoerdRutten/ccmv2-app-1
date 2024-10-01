<a href="{{ $href }}"
    {{
        $attributes->merge([
        'class' => 'block rounded-md px-3 py-2 text-center text-sm font-semibold text-gray-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600',
        ])
    }}
>
    @if ($slot->isEmpty())
        Terug
    @else
        {{ $slot }}
    @endif
</a>