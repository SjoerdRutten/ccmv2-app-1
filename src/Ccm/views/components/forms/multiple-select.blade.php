<div {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-0 py-1 pl-3 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white min-h-9']) }}
     @click="$focus.first()"
>
    <div x-data="textArray({ elements: @entangle('filter.value') })">
        <template x-for="(tag, index) in tags">
            <span class="inline-flex flex-shrink-0 items-center rounded-full bg-pink-100 px-1.5 py-0.5 text-xs font-medium text-pink-700 ring-1 ring-inset ring-pink-600/20 mr-1"
            >
                <span x-text="tag"></span>
                <x-heroicon-s-x-circle
                        class="ml-1 w-4 h-4 cursor-pointer"
                        @click="removeElement(index)"
                />
            </span>
        </template>

        <span class="inline-flex flex-shrink-0 items-center rounded-full bg-gray-100 px-1.5 py-0.5 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20 mr-1 cursor-pointer"
              :class="tags.length > 0 ? '' : 'hidden'"
              @click="removeAll()"
        >
        <span class="text-gray-400">
                    Alles verwijderen
                    <span x-text="tags.length"></span>
                </span>
        <x-heroicon-s-x-circle
                class="ml-1 w-4 h-4"
        />
        </span>

        <input type="text"
               class="p-0 border-transparent focus:border-transparent focus:ring-0"
               x-model="newElement"
               @keyup.enter="addElement()"
        />
    </div>
</div>