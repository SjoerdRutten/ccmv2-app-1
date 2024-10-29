<tr @if ($route ?? false) x-on:dblclick="document.location.href = '{{ $route }}'"
    @endif class="hover:bg-gray-50 cursor-pointer">
    {{ $slot }}
</tr>