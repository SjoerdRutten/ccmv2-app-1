<x-ccm::cards.card title="Typesense">
    <x-ccm::definition-list.row title="Disk usage">
        {{ ReadableSize($metrics['typesense_memory_resident_bytes']) }}
    </x-ccm::definition-list.row>
    <x-ccm::definition-list.row title="Memory available">
        {{ ReadableSize($metrics['system_memory_total_bytes']) }}
    </x-ccm::definition-list.row>
    <x-ccm::definition-list.row title="Memory used">
        {{ ReadableSize($metrics['typesense_memory_active_bytes']) }}
    </x-ccm::definition-list.row>
</x-ccm::cards.card>

{{-- Beschikbare keys,nog uitzoeken wat precies wat is--}}
{{--system_disk_total_bytes--}}
{{--system_disk_used_bytes--}}
{{--system_memory_total_bytes--}}
{{--system_memory_used_bytes--}}
{{--typesense_memory_active_bytes--}}
{{--typesense_memory_allocated_bytes--}}
{{--typesense_memory_fragmentation_ratio--}}
{{--typesense_memory_mapped_bytes--}}
{{--typesense_memory_metadata_bytes--}}
{{--typesense_memory_resident_bytes--}}
{{--typesense_memory_retained_bytes--}}