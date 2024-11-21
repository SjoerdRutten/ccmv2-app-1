<div {{ $attributes->merge(['class' => 'border border-gray-300 bg-gray-200 my-2 flex flex-col relative gap-2 rounded']) }}>
    <div class="p-2">
        {{ $slot }}
    </div>
    @if ($buttons ?? false)
        <div class="bg-gray-100 border-t border-gray-300 p-2">
            {{ $buttons }}
        </div>
    @endif
</div>