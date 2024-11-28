<li {{ $attributes->merge(['class' => 'block border border-gray-200 rounded-lg py-2 px-4 group flex items-center cursor-move']) }}
    x-sort:item="{{ $id }}"
>
    {{ $slot }}
</li>