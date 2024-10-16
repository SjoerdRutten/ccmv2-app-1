@props([
    'id' => uniqid(),
    'name' => uniqid(),
])

<input type="hidden" name="{{ $name }}" id="{{ $id }}" wire:key="{{ $name }}" {{ $attributes }} >