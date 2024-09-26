@props([
    'first' => false,
    'link' => false,
])

@if ($first)
    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
        {{ $slot }}
    </th>
@elseif ($link)
    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
        <span class="sr-only">{{ $slot }}</span>
    </th>
@else
    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
        {{ $slot }}
    </th>
@endif