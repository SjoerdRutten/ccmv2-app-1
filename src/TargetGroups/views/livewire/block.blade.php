<div class="border border-gray-300 bg-gray-200 p-2 my-1 flex flex-col relative gap-2 rounded">
    @if ($index > 0)
        <button wire:click="toggleOperator" class="absolute -top-[18px] bg-white border border-gray-500 px-2 rounded">
            {{ Arr::get($element, 'operation') }}
        </button>
    @endif
    <div>
        @foreach (Arr::get($element, 'subelements') AS $key => $subElement)
            @if (Arr::get($subElement, 'type') === 'rule')
                <livewire:target-group-selector::rule
                        wire:model.blur="{{ $this->getRuleKey($key) }}"
                        wire:key="{{ hash('md5', serialize($subElement)) }}"
                        :readonly="$readonly"
                        :index="$key"
                />
            @endif
        @endforeach
    </div>
    @if (!$readonly)
        <div class="flex flex-row gap-4 mt-4">
            <a href="#" wire:click.prevent="addRule">
                <x-heroicon-s-plus-circle class="w-5 h-5 inline"/>
                Criterium toevoegen
            </a>
            <a href="#"
               class="text-red-500"
               wire:confirm="Weet je zeker dat je dit blok wilt verwijderen ?"
               wire:click.prevent="$parent.removeElement('{{ $index }}')"
            >
                <x-heroicon-s-trash class="w-5 h-5 inline"/>
                Blok verwijderen
            </a>
        </div>
    @endif
</div>