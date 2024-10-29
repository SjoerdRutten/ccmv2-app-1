<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Typesense;

use Livewire\Component;

class Collection extends Component
{
    public string $collectionName;

    public function render()
    {
        $collection = \Typesense::getCollection($this->collectionName);

        $fields = new \Illuminate\Support\Collection($collection['fields']);

        $fields = $fields->sortBy(fn ($field) => $field['name']);

        return view('ccm::livewire.typesense.collection')
            ->with([
                'collection' => $collection,
                'fields' => $fields,
            ]);
    }
}
