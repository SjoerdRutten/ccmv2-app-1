@props([
    'id' => uniqid()
])

<div class="relative flex items-start">
    <div class="flex items-center">
        <input name="{{ $id }}" type="checkbox"
            {{ $attributes->merge([
                'id' => $id,
                'class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600'
                ]) }}
        >
    </div>
    @if ($slot->isNotEmpty())
        <div class="ml-3 text-sm">
            <label for="{{ $id }}" class="font-medium text-gray-900">
                {{ $slot }}
            </label>
        </div>
    @endif
</div>