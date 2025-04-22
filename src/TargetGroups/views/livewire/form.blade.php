<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="Doelgroep selector">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('target-groups::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>
        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">
                    Query builder
                    <x-slot:badge>
                        @if ($targetGroup->id)
                            {{--                            <livewire:target-group-selector::target-group-row-count key="TGCounter"--}}
                            {{--                                                                                    :target-group-id="$targetGroup->id"--}}
                            {{--                                                                                    wire:loading.remove--}}
                            {{--                                                                                    lazy--}}

                            {{--                            />--}}
                        @endif
                    </x-slot:badge>
                </x-ccm::tabs.nav-tab>
                @if ($id > 0)
                    @if (Auth::user()->hasPermissionTo('gds', 'export'))
                        <x-ccm::tabs.nav-tab :index="3">Export</x-ccm::tabs.nav-tab>
                    @endif
                    <x-ccm::tabs.nav-tab :index="2">Logs</x-ccm::tabs.nav-tab>
                @endif
                @if (Auth::user()->isAdmin)
                    <x-ccm::tabs.nav-tab :index="1">Debug</x-ccm::tabs.nav-tab>
                @endif
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="name" wire:model="name">Naam</x-ccm::forms.input>
                    <x-ccm::forms.categories name="category_id" wire:model="category_id"></x-ccm::forms.categories>
                    <x-ccm::forms.textarea name="description" wire:model="description">
                        Omschrijving
                    </x-ccm::forms.textarea>
                </div>

                <div class="flex flex-col mt-10">
                    @foreach ($elements AS $key => $element)
                        @if (Arr::get($element, 'type') === 'block')
                            <livewire:target-group-selector::block
                                    wire:model.live="elements.{{ $key }}"
                                    wire:key="BLOCK{{ $key }}"
                                    :index="$key"
                                    :top="true"
                            />
                        @endif
                    @endforeach
                </div>

                <x-ccm::buttons.primary wire:click="addBlock"
                                        icon="heroicon-s-plus"
                >
                    Blok toevoegen
                </x-ccm::buttons.primary>

                <x-slot:buttons>
                    <x-ccm::buttons.primary wire:click="showTagModal = true">
                        Kenmerk toevoegen aan selectie
                    </x-ccm::buttons.primary>
                </x-slot:buttons>

            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                {{ $this->getMql() }}
            </x-ccm::tabs.tab-content>
            @if ($id > 0)
                <x-ccm::tabs.tab-content :index="2" :no-margin="true">
                    <x-ccm::activity_log.table :performed_on="$targetGroup"></x-ccm::activity_log.table>
                </x-ccm::tabs.tab-content>
                <x-ccm::tabs.tab-content :index="3" no-margin="true">
                    <div class="px-6 py-6">
                        <h2>Nieuwe export aanmaken</h2>

                        <div class="flex flex-col gap-4 w-1/2" x-on:hide-modal="$refresh">
                            <div class="flex items-end gap-4">
                                @if (count($fieldSets))
                                    <x-ccm::forms.select label="Veldenset"
                                                         wire:model.live="export.targetGroupFieldSetId"
                                                         class="w-[400px]">
                                        <option></option>
                                        @foreach ($fieldSets AS $fieldSet)
                                            <option value="{{ $fieldSet->id }}">
                                                {{ $fieldSet->name }}
                                                ({{ $fieldSet->crmFields()->count() }} velden)
                                            </option>
                                        @endforeach
                                    </x-ccm::forms.select>
                                @endif
                                @if ($export['targetGroupFieldSetId'] > 0)
                                    TODO!!
                                    <x-ccm::buttons.edit>&nbsp;</x-ccm::buttons.edit>
                                    <x-ccm::buttons.delete>&nbsp;</x-ccm::buttons.delete>
                                @endif

                                <livewire:target-group-selector::create-target-group-fieldset/>
                            </div>
                            @if ($export['targetGroupFieldSetId'] > 0)
                                <x-ccm::forms.select label="Bestandsformaat" wire:model.live="export.file_type">
                                    <option value="xlsx">Excel (xlsx)</option>
                                    <option value="csv">CSV</option>
                                </x-ccm::forms.select>

                                <div>
                                    <x-ccm::buttons.primary wire:click="startExport">Export starten
                                    </x-ccm::buttons.primary>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($targetGroup->targetGroupExports()->count())
                        <x-ccm::tables.table :no-margin="true">
                            <x-slot:thead>
                                <x-ccm::tables.th :first="true">Status</x-ccm::tables.th>
                                <x-ccm::tables.th>Aangemaakt door</x-ccm::tables.th>
                                <x-ccm::tables.th>Aangemaakt op</x-ccm::tables.th>
                                <x-ccm::tables.th>Bestandsformaat</x-ccm::tables.th>
                                <x-ccm::tables.th>Aantal records</x-ccm::tables.th>
                                <x-ccm::tables.th>Verwachtte eindtijd</x-ccm::tables.th>
                                <x-ccm::tables.th :link="true"></x-ccm::tables.th>
                            </x-slot:thead>
                            <x-slot:tbody>
                                @foreach ($targetGroup->targetGroupExports()->latest()->get() AS $export)
                                    <x-ccm::tables.tr>
                                        <x-ccm::tables.td :first="true">
                                            @if ($export->status === 0)
                                                Ingepland
                                            @elseif ($export->status === 1)
                                                Wordt uitgevoerd
                                            @elseif ($export->status === 2)
                                                Klaar
                                            @elseif ($export->status === 99)
                                                Fout
                                            @endif
                                        </x-ccm::tables.td>
                                        <x-ccm::tables.td>{{ $export->user->name }}</x-ccm::tables.td>
                                        <x-ccm::tables.td>{{ $export->created_at }}</x-ccm::tables.td>
                                        <x-ccm::tables.td>{{ $export->file_type }}</x-ccm::tables.td>
                                        <x-ccm::tables.td>
                                            {{ ReadableNumber($export->progress, '.') }} /
                                            {{ ReadableNumber($export->number_of_records, '.') }}
                                        </x-ccm::tables.td>
                                        <x-ccm::tables.td>
                                            @if ($export->status === 1)
                                                {{ $export->expected_end_time?->translatedFormat('H:i') }}
                                            @endif
                                        </x-ccm::tables.td>
                                        <x-ccm::tables.td :link="true">
                                            @if ($export->disk && $export->path && ($export->status === 2))
                                                <x-ccm::tables.download-link
                                                        wire:click="downloadExport({{ $export->id }})"></x-ccm::tables.download-link>
                                            @endif
                                            @if ($export->status !== 1)
                                                <x-ccm::tables.delete-link
                                                        wire:confirm="Weet je zeker dat je deze export wilt verwijderen ?"
                                                        wire:click="deleteExport({{ $export->id }})"
                                                ></x-ccm::tables.delete-link>
                                            @endif
                                        </x-ccm::tables.td>
                                    </x-ccm::tables.tr>
                                @endforeach
                            </x-slot:tbody>
                        </x-ccm::tables.table>
                    @endif
                </x-ccm::tabs.tab-content>
            @endif

        </x-ccm::tabs.base>

        <div x-data="{ show: @entangle('showTagModal') }">
            <x-ccm::layouts.modal
                    title="Kenmerk toevoegen"
            >
                <x-ccm::forms.form class="w-full">
                    <x-ccm::forms.input name="tag" wire:model="tag">Kenmerk</x-ccm::forms.input>
                    <x-ccm::forms.input name="fieldName" wire:model="fieldName">Veld</x-ccm::forms.input>
                    <x-ccm::forms.input name="seperator" wire:model="seperator">Schijdingsteken</x-ccm::forms.input>
                </x-ccm::forms.form>

                <x-slot:buttons>
                    <x-ccm::buttons.primary wire:click.prevent="addTag">
                        Tag toevoegen aan CRM kaarten
                    </x-ccm::buttons.primary>
                    <x-ccm::buttons.secundary wire:click="showTagModal = false">
                        Annuleren
                    </x-ccm::buttons.secundary>
                </x-slot:buttons>
            </x-ccm::layouts.modal>
        </div>
    </div>
</div>
