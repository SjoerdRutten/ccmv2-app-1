@props([
    'first' => false,
    'link' => false,
])

@if ($first)
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $slot }}
    </td>
@elseif ($link)
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
        {{ $slot }}
    </td>
@else
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{ $slot }}
    </td>
@endif