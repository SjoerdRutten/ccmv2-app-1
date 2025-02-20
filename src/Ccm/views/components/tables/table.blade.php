<div class="{{ ($noMargin ?? false) ?: 'px-4 sm:px-6 lg:px-8 mt-8' }} flow-root">
    <div class="{{ ($noMargin ?? false) ? 'border-t border-gray-200' : '-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 rounded-xl border border-gray-200' }} bg-gray-50">
        <div class="inline-block min-w-full pt-2 align-middle">
            <table class="min-w-full divide-y divide-gray-300" {{ $attributes }}>
                @if ($thead ?? false)
                    <thead>
                    <tr>
                        {{ $thead ?? null}}
                    </tr>
                    </thead>
                @endif
                <tbody class="divide-y divide-gray-200 bg-white"
                       @if ($sortable ?? false)
                           x-sort.ghost="handle"
                        @endif
                >
                {{ $tbody }}
                </tbody>
                @if ($tfoot ?? false)
                    <tfoot>

                    </tfoot>
                @endif
            </table>
        </div>
        @if ($pagination ?? false)
            <div class="px-5 py-2">
                {{ $pagination ?? '' }}
            </div>
        @endif
        {{ $postTable ?? '' }}
    </div>
</div>