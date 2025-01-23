<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Taak wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::scheduler::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Actie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Planning</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input name="form.name"
                                        wire:model="form.name"
                                        :required="true"
                    >
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.description"
                                        wire:model="form.description"
                    >
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.checkbox name="form.is_active"
                                           wire:model="form.is_active">
                        Actief
                    </x-ccm::forms.checkbox>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.select wire:model.live="form.type" label="Soort taak">
                        <option></option>
                        @foreach (\Sellvation\CCMV2\Scheduler\Enums\ScheduleTaskType::cases() AS $task)
                            <option value="{{ $task->value }}">
                                {{ $task->name() }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>

                    @if ($form->type === 'extension')
                        <x-ccm::forms.select wire:model="form.command" label="Taak">
                            <option></option>
                            <option value="empty">Leeg</option>

                        </x-ccm::forms.select>
                    @elseif ($form->type !== '')
                        Nog te implementeren
                    @endif
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
