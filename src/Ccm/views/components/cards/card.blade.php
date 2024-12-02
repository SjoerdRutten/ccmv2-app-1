<li class="overflow-hidden rounded-xl border border-gray-200 bg-white">
    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-6 py-3">
        <div>
            <div class="text-md font-medium leading-6 text-gray-900">{{ $title }}</div>
            @if ($subtitle ?? false)
                <div class="text-sm font-medium leading-6 text-gray-700 italic">{{ $subtitle }}</div>
            @endif
        </div>
        {{--        <div class="relative ml-auto">--}}
        {{--            <button type="button" class="-m-2.5 block p-2.5 text-gray-400 hover:text-gray-500"--}}
        {{--                    id="options-menu-2-button" aria-expanded="false" aria-haspopup="true">--}}
        {{--                <span class="sr-only">Open options</span>--}}
        {{--                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"--}}
        {{--                     data-slot="icon">--}}
        {{--                    <path d="M3 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM8.5 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM15.5 8.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z"/>--}}
        {{--                </svg>--}}
        {{--            </button>--}}

        {{--            <!----}}
        {{--              Dropdown menu, show/hide based on menu state.--}}

        {{--              Entering: "transition ease-out duration-100"--}}
        {{--                From: "transform opacity-0 scale-95"--}}
        {{--                To: "transform opacity-100 scale-100"--}}
        {{--              Leaving: "transition ease-in duration-75"--}}
        {{--                From: "transform opacity-100 scale-100"--}}
        {{--                To: "transform opacity-0 scale-95"--}}
        {{--            -->--}}
        {{--            <div class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"--}}
        {{--                 role="menu" aria-orientation="vertical" aria-labelledby="options-menu-2-button" tabindex="-1">--}}
        {{--                <!-- Active: "bg-gray-50", Not Active: "" -->--}}
        {{--                <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem"--}}
        {{--                   tabindex="-1" id="options-menu-2-item-0">View<span class="sr-only">, Reform</span></a>--}}
        {{--                <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem"--}}
        {{--                   tabindex="-1" id="options-menu-2-item-1">Edit<span class="sr-only">, Reform</span></a>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
    <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
        {{ $slot }}
    </dl>
</li>