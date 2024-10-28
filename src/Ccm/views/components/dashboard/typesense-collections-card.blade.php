<x-ccm::cards.card title="Typesense collections">
    @foreach ($collections AS $collection)
        <x-ccm::definition-list.row :title="$collection['name']">
            {{ ReadableNumber($collection['num_documents']) }}
        </x-ccm::definition-list.row>
    @endforeach
</x-ccm::cards.card>