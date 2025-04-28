<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Extensie wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('admin::extensions::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basis informatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Instellingen</x-ccm::tabs.nav-tab>
            </x-slot:tabs>
            <x-ccm::tabs.tab-content :index="1">
                @foreach ($settings AS $key => $row)
                    @if (\Illuminate\Support\Str::startsWith($key, 'content'))
                        <p>
                            {{ $row }}
                        </p>
                    @elseif (\Illuminate\Support\Str::startsWith($key, 'block'))
                        <x-extensions::block :block="$row"/>
                    @elseif (\Illuminate\Support\Str::startsWith($key, 'fields'))
                        <x-extensions::fields :fields="$row"/>
                    @endif
                @endforeach
            </x-ccm::tabs.tab-content>
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
                    <x-ccm::forms.input-datetime name="form.start_at"
                                                 wire:model="form.start_at">
                        Starttijd
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.input-datetime name="form.end_at"
                                                 wire:model="form.end_at">
                        Eindtijd
                    </x-ccm::forms.input-datetime>
                    <x-ccm::forms.select name="form.event" wire:model="form.event" :required="true" label="Event">
                        <option></option>
                        @foreach ($events AS $class => $name)
                            <option value="{{ $class }}">
                                {{ class_basename($class) }} -
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.select name="form.job" wire:model.live="form.job" :required="true"
                                         label="Job">
                        <option></option>
                        @foreach ($jobs AS $class => $name)
                            <option value="{{ $class }}">
                                {{ class_basename($class) }} -
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
