<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $title }}</h1>
        <p class="mt-2 text-sm text-gray-700">{{ $slot }}</p>
    </div>
    @if ($actions ?? false)
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            {{ $actions }}
        </div>
    @endif
</div>