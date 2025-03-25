<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Disktype wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::disktypes::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
            </x-slot:tabs>
            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.name"
                                        wire:model="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select name="form.disk_id"
                                         wire:model.live="form.disk_id"
                                         :required="true"
                                         label="Disk">
                        <option></option>
                        @foreach ($disks AS $disk)
                            <option value="{{ $disk->id }}">
                                {{ $disk->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
