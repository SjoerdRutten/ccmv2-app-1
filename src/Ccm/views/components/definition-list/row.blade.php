<div class="flex justify-between gap-x-4 py-3">
    <dt class="text-gray-500">
        @if ($href ?? false)
            <a href="{{ $href }}">
                {{ $title }}
            </a>
        @else
            {{ $title }}
        @endif
    </dt>
    <dd class="text-gray-700">
        {{ $slot }}
    </dd>
</div>