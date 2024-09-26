<div wire:loading.remove class="p-5">
    <div class="mb-8">
        Aantal resultaten:
        {{ $this->count() }}
    </div>

    <div class="flex flex-col">
        @foreach ($elements AS $key => $element)
            <x-target-group::block :elements="$elements" :element="$element" :index="$key"/>
        @endforeach
    </div>


    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            wire:click="addBlock"
    >
        Blok toevoegen
    </button>
    <div class="my-8">
        <h3>Filters opslaan</h3>
        <input type="text" wire:model="name"/>
        <button wire:click="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Opslaan
        </button>
    </div>

    <div class="text-xs italic">
        Gegenereerde query:
        {{ $this->getQueryFilters() }}
    </div>


    <div class="mt-10">
        <h1 class="text-2xl font-bold">Eerste 10 CRM ID's</h1>
        <h3 class="italic">Bij klikken op een ID, CRM kaart openen in popup?</h3>
        @foreach ($this->exampleResults AS $row)
            <div>{{ $row->crm_id }}</div>
        @endforeach
    </div>
</div>
