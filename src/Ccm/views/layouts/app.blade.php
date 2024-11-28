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
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/sort@3.x.x/dist/cdn.min.js"></script>

    @if (app()->environment('local'))
        <script defer src="/vendor/ccm/js/alpinejs-multiselect.js"></script>
        <script defer src="/vendor/ccm/js/alpinejs-productselect.js"></script>
        <script defer src="/vendor/ccm/js/alpinejs-fieldselect.js"></script>
    @else
        <script defer src="/vendor/ccm/js/alpinejs-multiselect.min.js"></script>
        <script defer src="/vendor/ccm/js/alpinejs-productselect.min.js"></script>
        <script defer src="/vendor/ccm/js/alpinejs-fieldselect.min.js"></script>
    @endif
    @stack('js')

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        .sortable-ghost {
            opacity: .3 !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Styles -->
    @livewireStyles
</head>
<body class="h-full bg-gray-100">
<div>
    <x-ccm::navigation.mobile-menu/>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-56 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-2 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
            <div class="flex h-24 shrink-0 items-center py-4">
                <img class="w-auto" src="{{ asset('assets/logo_ccmp.jpg') }}" alt="Sellvation">
            </div>
            <nav class="flex flex-1 flex-col">
                <x-ccm::navigation.desktop-menu/>
            </nav>
        </div>
    </div>

    <div class="lg:pl-56">
        <x-ccm::layouts.header/>
        <main class="py-10 bg-gray-100">
            <div class="px-4 sm:px-6 lg:px-8">
                @yield('content')
                {{ $slot ?? null }}
            </div>
        </main>
    </div>
</div>

<livewire:ccm::modal-success/>
<livewire:ccm::modal-error/>
@stack('modals')

</body>
</html>

