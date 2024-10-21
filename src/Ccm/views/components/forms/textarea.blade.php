@props([
    'id' => uniqid(),
    'name' => uniqid(),
    'disabled' => false,
])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $slot }}</label>
    <div class="mt-1">
        <textarea
                name="{{ $name }}"
                id="{{ $id }}"
                wire:key="{{ $name }}"
           {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge([
                         'class' => ($disabled ? 'bg-gray-200 ' : '').'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                     ])
                 }}
        ></textarea>
    </div>
    @if ($errors->has($name))
        <p class="mt-2 text-sm text-red-600" id="email-error">
            {{ $errors->first($name) }}
        </p>
    @endif

</div>
