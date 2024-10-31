<div x-show="currentTab === {{ $index }}">
    <div class="{{ ($noMargin ?? false) ?: 'px-6 py-6' }} bg-white border-l border-r border-gray-300
        @if (!($buttons ?? false))
            rounded-b-lg border-b
        @endif
    ">
        @if ($intro ?? false)
            <div class="{{ (!($noMargin ?? false)) ?: 'px-6 py-6' }}">
                {{ $intro }}
            </div>
        @endif

        {{ $slot }}
    </div>

    @if ($buttons ?? false)
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 rounded-b-lg border-b border-l border-r border-gray-300">
            {{ $buttons }}
        </div>
    @endif

</div>