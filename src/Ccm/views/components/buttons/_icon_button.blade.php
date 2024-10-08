<{{ ($href ?? false) ? 'a' : 'button'  }} {{ $attributes->merge(['class' => '']) }}>
@if ($icon ?? false)
    <x-dynamic-component :component="$icon" class="w-4 h-4 mr-1"/>
@endif
@if ($slot->isNotEmpty())
    {{ $slot }}
@endif
</{{ ($href ?? false) ? 'a' : 'button'  }}>