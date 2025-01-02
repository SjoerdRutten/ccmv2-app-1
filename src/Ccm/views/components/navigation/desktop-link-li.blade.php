@props([
    'route' => '',
    'label' => '',
    'sub' => false,
    'item' => null,
])

@if (!Arr::get($item, 'sub_items'))
    @if ($sub)
        <a href="{{ route($route) }}"
           class="{{ request()->routeIs($route) ? 'text-pink-500 font-bold' : 'text-gray-700' }} block rounded-md py-2 pl-9 pr-2 text-sm leading-6 hover:bg-gray-50">{{ $label }}</a>
    @else
        <a href="{{ route($route) }}"
           class="{{ request()->routeIs($route) ? 'text-pink-500 font-bold' : 'text-gray-700' }} group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 hover:text-pink-600 hover:bg-gray-50">
            {{ $label }}
        </a>
    @endif
@else
    <div>
        <button type="button"
                class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50"
                aria-controls="sub-menu-1"
                aria-expanded="false"
                x-on:click="open = (open === '{{ $label }}' ? null : '{{ $label }}')"
        >
            <div :class="open === '{{ $label }}' ? 'rotate-90 text-gray-500' : 'text-gray-400'">
                <x-heroicon-s-chevron-right class="h-3 w-3 shrink-0"/>
            </div>
            {{ $label }}
        </button>
        <ul class="mt-1 px-2" id="sub-menu-1"
            x-show="open === '{{ $label }}'">
            @foreach (Arr::get($item, 'sub_items') AS $subItem)
                <x-ccm::navigation.desktop-link
                        :route="Arr::get($subItem, 'route')"
                        :label="Arr::get($subItem, 'label')"
                        :sub="true"
                        :item="$subItem"/>
            @endforeach
        </ul>
    </div>
@endif
