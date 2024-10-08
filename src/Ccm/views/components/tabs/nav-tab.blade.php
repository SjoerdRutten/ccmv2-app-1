@props([
    'index' => 0,
    'badge' => null
])

<a href="#"
   class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium"
   x-on:click="currentTab = {{ $index }}"
   x-bind:class="currentTab === {{ $index }} ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
>
    {{ $slot }}

    @if ($badge !== null)
        <span class="ml-3 hidden rounded-full bg-pink-100 px-2.5 py-0.5 text-xs font-medium text-gray-900 md:inline-block">
            {{ $badge }}
        </span>
    @endif
</a>