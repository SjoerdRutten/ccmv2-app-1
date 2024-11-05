<{{ ($href ?? false) ? 'a' : 'button'  }} {{ $attributes->merge(['class' => 'block rounded-md px-3 h-8 text-center text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 flex items-center']) }}>

@if ($icon ?? false)
    <x-dynamic-component :component="$icon" class="w-4 h-4 mr-1"/>
@endif

@if ($slot->isNotEmpty())
    {{ $slot }}
@endif
</{{ ($href ?? false) ? 'a' : 'button'  }}>