@props([
    'id' => uniqid(),
    'name' => '',
])

<div class="relative flex items-start">
    <div class="flex items-center">
        <input type="checkbox"
            {{
                $attributes->merge([
                    'name' => $name,
                    'id' => $id,
                    'class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600'
                ])
            }}
        >
    </div>
    @if ($slot->isNotEmpty())
        <div class="ml-3 text-sm">
            <label for="{{ $id }}" class="font-medium text-gray-900">
                {{ $slot }}
            </label>
        </div>
    @endif

    @if ($errors->has($name))
        <p class="mt-2 text-sm text-red-600" id="email-error">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>