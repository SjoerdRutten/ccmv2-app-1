<tr @if ($route) x-on:dblclick="document.location.href = '{{ $route }}'"
    @endif class="hover:bg-gray-100 cursor-pointer">
    {{ $slot }}
</tr>