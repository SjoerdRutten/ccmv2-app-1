<tr @if ($route ?? false)
        x-on:dblclick="document.location.href = '{{ $route }}'"
    @endif
    class="hover:bg-gray-50 cursor-pointer"
    @if ($id ?? false)
        x-sort:item="{{ $id }}"
        @endif
>
    {{ $slot }}
</tr>