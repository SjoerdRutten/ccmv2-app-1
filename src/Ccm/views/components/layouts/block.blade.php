<div {{ $attributes->merge(['class' => 'border border-gray-300 bg-white my-2 flex flex-col relative gap-2 rounded']) }}>
    <div class="p-6">
        {{ $slot }}
    </div>
    @if ($buttons ?? false)
        <div class="bg-gray-100 border-t border-gray-300 py-2 px-6">
            {{ $buttons }}
        </div>
    @endif
</div>