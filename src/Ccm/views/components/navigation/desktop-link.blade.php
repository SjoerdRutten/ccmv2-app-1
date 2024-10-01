@props([
    'route' => '',
    'label' => '',
    'sub' => false,
])
<li>
    @if ($slot->isEmpty())
        @if ($sub)
            <a href="{{ route($route) }}" class="block rounded-md py-2 pl-9 pr-2 text-sm leading-6 text-gray-700 hover:bg-gray-50">{{ $label }}</a>
        @else
            <!-- Current: "bg-gray-50 text-indigo-600", Default: "text-gray-700 hover:text-indigo-600 hover:bg-gray-50" -->
            <a href="{{ route($route) }}" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:text-indigo-600 hover:bg-gray-50">
                {{ $label }}
            </a>
        @endif
    @else
        <div>
            <button type="button" class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50" aria-controls="sub-menu-1" aria-expanded="false">
                <!-- Expanded: "rotate-90 text-gray-500", Collapsed: "text-gray-400" -->
                <svg class="h-5 w-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
                {{ $label }}
            </button>
            <!-- Expandable link section, show/hide based on state. -->
            <ul class="mt-1 px-2" id="sub-menu-1">
                {{ $slot  }}
            </ul>
        </div>
    @endif


</li>