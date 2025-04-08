<div class="mt-6 px-4">
    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">{{ $title }}</h3>
    </div>
    <dl class="grid grid-cols-1 sm:grid-cols-2 px-4 gap-4" x-sort="$wire.setFieldPosition($item, $position)">
        {{ $slot }}
    </dl>
</div>