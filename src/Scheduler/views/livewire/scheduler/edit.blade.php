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
                        <x-ccm::forms.select wire:model.live="form.command" label="Taak">
                            <option></option>
                            @foreach ($commands AS $key => $_command)
                                <option value="{{ $key }}">
                                    {{ $_command->getName() }}
                                </option>
                            @endforeach
                        </x-ccm::forms.select>
                        <x-ccm::forms.checkbox name="form.on_one_server"
                                               wire:model="form.on_one_server">
                            Op 1 server uitvoeren
                        </x-ccm::forms.checkbox>
                        <x-ccm::forms.checkbox name="form.without_overlapping"
                                               wire:model="form.without_overlapping">
                            Zonder overlapping
                        </x-ccm::forms.checkbox>

                        @if ($command)
                            @if (count($command->getDefinition()->getArguments()))
                                <x-ccm::typography.h2>Argumenten</x-ccm::typography.h2>
                                @foreach($command->getDefinition()->getArguments() AS $argument)
                                    <x-ccm::forms.input
                                            wire:model="form.arguments.{{ $argument->getName() }}"
                                            :required="$argument->isRequired()"
                                    >
                                        {{ $argument->getDescription() ?: $argument->getName() }}
                                        @if ($argument->isArray())
                                            (Meerde waarden gescheiden met een spatie)
                                        @endif
                                    </x-ccm::forms.input>
                                @endforeach
                            @endif
                            @if (count($command->getDefinition()->getOptions()))
                                <x-ccm::typography.h2>Opties</x-ccm::typography.h2>
                                @foreach($command->getDefinition()->getOptions() AS $option)
                                    <x-ccm::forms.checkbox name="form.options.{{ $option->getName() }}"
                                                           wire:model.live="form.options.{{ $option->getName() }}">
                                        {{ $option->getDescription() ?: $option->getName() }}
                                    </x-ccm::forms.checkbox>
                                    @if ($option->acceptValue() && Arr::get($form->options, $option->getName()))
                                        <x-ccm::forms.input
                                                wire:model="form.options.{{ $option->getName() }}_value"
                                                :required="$option->isValueRequired()"
                                        >
                                            Waarde voor {{ $option->getName() }}
                                            @if ($option->isArray())
                                                (Meerde waarden gescheiden met een spatie)
                                            @endif
                                        </x-ccm::forms.input>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @elseif ($form->type !== '')
                        Nog te implementeren
                    @endif
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::forms.form class="w-1/2">
                    <x-ccm::forms.input-datetime name="form.start_at"
                                                 wire:model="form.start_at"
                    >
                        Starttijd
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.input-datetime name="form.end_at"
                                                 wire:model="form.end_at"
                    >
                        Eindtijd
                    </x-ccm::forms.input-datetime>

                    <x-ccm::typography.h2>Planning</x-ccm::typography.h2>
                    <x-ccm::forms.select wire:model.live="form.pattern.type" label="Interval">
                        <option></option>
                        @foreach (\Sellvation\CCMV2\Scheduler\Enums\ScheduleIntervals::cases() AS $interval)
                            <option value="{{ $interval->name }}">
                                {{ $interval->name() }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>

                    @if($form->pattern['type'] === \Sellvation\CCMV2\Scheduler\Enums\ScheduleIntervals::dailyAt->name)
                        <x-ccm::forms.input-time wire:model="form.pattern.time">Tijdstip</x-ccm::forms.input-time>
                    @elseif($form->pattern['type'] === \Sellvation\CCMV2\Scheduler\Enums\ScheduleIntervals::weeklyOn->name)
                        <div class="flex gap-4">
                            <x-ccm::forms.checkbox wire:model="form.pattern.days" value="1">Ma</x-ccm::forms.checkbox>
                            <x-ccm::forms.checkbox wire:model="form.pattern.days" value="2">Di</x-ccm::forms.checkbox>
                            <x-ccm::forms.checkbox wire:model="form.pattern.days" value="3">Wi</x-ccm::forms.checkbox>
                            <x-ccm::forms.checkbox wire:model="form.pattern.days" value="4">Do</x-ccm::forms.checkbox>
                            <x-ccm::forms.checkbox wire:model="form.pattern.days" value="5">Vr</x-ccm::forms.checkbox>
                            <x-ccm::forms.checkbox wire:model="form.pattern.days" value="6">Za</x-ccm::forms.checkbox>
                            <x-ccm::forms.checkbox wire:model="form.pattern.days" value="7">Zo</x-ccm::forms.checkbox>
                        </div>
                        <x-ccm::forms.input-time wire:model="form.pattern.time">Tijdstip</x-ccm::forms.input-time>
                    @elseif($form->pattern['type'] === \Sellvation\CCMV2\Scheduler\Enums\ScheduleIntervals::monthlyOn->name)
                        <x-ccm::forms.select wire:model.live="form.pattern.day" label="Dag van de maand">
                            @for ($i = 1; $i <= 28; $i++)
                                <option value="{{ $i }}">
                                    {{ $i }}
                                </option>
                            @endfor
                        </x-ccm::forms.select>
                        <x-ccm::forms.input-time wire:model="form.pattern.time">Tijdstip</x-ccm::forms.input-time>
                    @elseif($form->pattern['type'] === \Sellvation\CCMV2\Scheduler\Enums\ScheduleIntervals::yearlyOn->name)
                        <div class="flex gap-4">
                            <x-ccm::forms.select wire:model.live="form.pattern.day" label="Dag van de maand">
                                @for ($i = 1; $i <= 28; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                @endfor
                            </x-ccm::forms.select>
                            <x-ccm::forms.select wire:model.live="form.pattern.month" label="Maand">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                @endfor
                            </x-ccm::forms.select>
                        </div>
                        <x-ccm::forms.input-time wire:model="form.pattern.time">Tijdstip</x-ccm::forms.input-time>
                    @endif

                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
