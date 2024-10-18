{{-- Hidden div just for the css pre-processor --}}
<div class="hidden lg:grid-cols-1 lg:grid-cols-2 lg:grid-cols-3 lg:grid-cols-4 lg:grid-cols-5"></div>
<ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-{{ $cols ?? 3 }} xl:gap-x-8">
    {{ $slot }}
</ul>