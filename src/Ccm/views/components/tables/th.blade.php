@props([
    'first' => false,
    'link' => false,
])

@if ($first)
    <th scope="col" {{ $attributes->class('bg-gray-50 py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8') }}>
        {{ $slot }}
    </th>
@elseif ($link)
    <th scope="col" {{ $attributes->class('bg-gray-50 py-3.5 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8 text-right') }}>
        {{ $slot }}
    </th>
@else
    <th scope="col" {{ $attributes->class('bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900') }}>
        {{ $slot }}
    </th>
@endif