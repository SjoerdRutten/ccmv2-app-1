<div x-data="{ currentTab: $persist({{ $currentTab ?? 0 }}).as('{{ request()->route()->getName() }}')  }">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-2" aria-label="Tabs">
            {{ $tabs }}
        </nav>
    </div>
    {{ $slot }}
</div>