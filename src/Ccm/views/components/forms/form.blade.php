<form {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}>
    {{ $slot }}
</form>