<div {{ $attributes->class('border-t border-gray-100 px-4 py-2 sm:px-0')->except('crm-field') }} @if ($crmField ?? false )x-sort:item="{{ $crmField->id }}" @endif>
    <dt class="text-sm font-medium leading-6 text-gray-900 flex justify-between group">
        {{ $label }}
        <x-heroicon-s-arrows-pointing-out class="w-4 h-4 hidden group-hover:inline" x-sort:handle/>
    </dt>
    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2">{{ $slot }}</dd>
</div>