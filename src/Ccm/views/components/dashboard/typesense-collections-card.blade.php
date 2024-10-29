<x-ccm::cards.card title="Typesense collections">
    @foreach ($collections AS $collection)
        <x-ccm::definition-list.row :title="$collection['name']"
                                    :href="route('ccm::typesense.collection', $collection['name'])">
            {{ ReadableNumber($collection['num_documents']) }}
        </x-ccm::definition-list.row>
    @endforeach
</x-ccm::cards.card>