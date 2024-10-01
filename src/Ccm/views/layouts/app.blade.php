<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="h-full">
<div>
    <x-ccm::navigation.mobile-menu />

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            </div>
            <nav class="flex flex-1 flex-col">
                <x-ccm::navigation.desktop-menu />
            </nav>
        </div>
    </div>

    <div class="lg:pl-72">
        <x-ccm::layouts.header />
        <main class="py-10">
            <div class="px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

{{--<!-- Global notification live region, render this permanently at the end of the document -->--}}
{{--<div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:py-16 z-50">--}}
{{--    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">--}}
{{--        <!----}}
{{--          Notification panel, dynamically insert this into the live region when it needs to be displayed--}}

{{--          Entering: "transform ease-out duration-300 transition"--}}
{{--            From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"--}}
{{--            To: "translate-y-0 opacity-100 sm:translate-x-0"--}}
{{--          Leaving: "transition ease-in duration-100"--}}
{{--            From: "opacity-100"--}}
{{--            To: "opacity-0"--}}
{{--        -->--}}
{{--        <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">--}}
{{--            <div class="p-4">--}}
{{--                <div class="flex items-start">--}}
{{--                    <div class="flex-shrink-0">--}}
{{--                        <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                    <div class="ml-3 w-0 flex-1 pt-0.5">--}}
{{--                        <p class="text-sm font-medium text-gray-900">Successfully saved!</p>--}}
{{--                        <p class="mt-1 text-sm text-gray-500">Anyone with a link can now view this file.</p>--}}
{{--                    </div>--}}
{{--                    <div class="ml-4 flex flex-shrink-0">--}}
{{--                        <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">--}}
{{--                            <span class="sr-only">Close</span>--}}
{{--                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />--}}
{{--                            </svg>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}



@stack('modals')

</body>
</html>

