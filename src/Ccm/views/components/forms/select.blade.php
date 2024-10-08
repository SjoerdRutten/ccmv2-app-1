@props([
    'id' => uniqid(),
    'label' => '',
    'name' => '',
    'disabled' => false,
    'grow' => false,
    'divClass' => ''
])

<div class="{{ $grow ? 'grow' : '' }} {{ $divClass }}">
    @if (filled($label))
        <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $label }}</label>
    @endif
    <select id="{{ $id }}"
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6'
            ]) }}
            {{ $disabled ? 'disabled' : '' }}
    >
        {{ $slot }}
    </select>
    @if ($errors->has($name))
        <p class="mt-2 text-sm text-red-600" id="email-error">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>