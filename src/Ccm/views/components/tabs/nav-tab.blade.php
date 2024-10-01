<a href="#"
   class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium"
   x-on:click="currentTab = {{ $index }}"
   x-bind:class="currentTab === {{ $index }} ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
>
    <span>{{ $slot }}</span>
</a>