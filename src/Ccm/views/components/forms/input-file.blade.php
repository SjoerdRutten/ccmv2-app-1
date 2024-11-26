@props([
    'id' => uniqid(),
    'name' => uniqid(),
    'disabled' => false,
    'required' => false,
    'grow' => false,
])

<div class="{{ $grow ? 'grow' : '' }}">
    <label for="{{ $id }}"
           class="block text-sm font-medium leading-6 text-gray-900">{{ $slot }}{{ $required ? '*' : '' }}</label>
    <div class="mt-1 flex items-center gap-4">
        <input type="file"
               name="{{ $name }}"
               id="{{ $id }}"
               wire:key="{{ $name }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge([
                         'class' => ($disabled ? 'bg-gray-200 ' : '').'block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                     ])
                 }}
        >
        @if ($preview ?? false)
            {{ $preview }}
        @endif
    </div>
    @if ($errors->has($name))
        <p class="mt-2 text-sm text-red-600" id="email-error">
            {{ $errors->first($name) }}
        </p>
    @endif

</div>
