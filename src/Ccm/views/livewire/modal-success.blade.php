<div x-data="{ show: @entangle('showModal') }">
    <x-ccm::layouts.modal width="xl">
        <div class="sm:flex sm:items-center">
            <x-heroicon-s-check-circle class="w-12 h-12 text-green-600"/>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900"
                    id="modal-title">{{ $title }}</h3>
                <div class="mt-2">
                    {!! $content !!}
                </div>
            </div>
        </div>

        <x-slot:buttons>
            @if ($href)
                <x-ccm::buttons.primary
                        :href="$href"
                        x-on:click="show = false">
                    Sluiten
                </x-ccm::buttons.primary>
            @else
                <x-ccm::buttons.primary x-on:click="show = false">
                    Sluiten
                </x-ccm::buttons.primary>
            @endif
        </x-slot:buttons>
    </x-ccm::layouts.modal>
</div>