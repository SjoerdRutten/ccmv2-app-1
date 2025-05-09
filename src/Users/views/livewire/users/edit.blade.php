<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro :title="$user->id ? 'Gebruiker '.$user->name . ' wijzigen': 'Gebruiker toevoegen'">
            <x-slot:title_tags>
                @if ($user->active)
                    <x-ccm::tags.success>Actief</x-ccm::tags.success>
                @else
                    <x-ccm::tags.error>Inactief</x-ccm::tags.error>
                @endif
            </x-slot:title_tags>
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('users::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Gegevens</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Adressen</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Login</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="3">Rollen</x-ccm::tabs.nav-tab>
                {{--                <x-ccm::tabs.nav-tab :index="4">Rechten</x-ccm::tabs.nav-tab>--}}
                <x-ccm::tabs.nav-tab :index="5">API-tokens</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <x-ccm::forms.form>
                    <x-ccm::forms.select name="form.gender" wire:model="form.gender" label="Sekse">
                        <option value="0">De heer</option>
                        <option value="1">Mevrouw</option>
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.first_name" wire:model="form.first_name">
                        Voornaam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.suffix" wire:model="form.suffix">
                        Tussenvoegsel
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.last_name" wire:model="form.last_name">
                        Achternaam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.department" wire:model="form.department">
                        Afdeling
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.email" wire:model="form.email">
                        E-mail
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.telephone" wire:model="form.telephone">
                        Telefoonnummer
                    </x-ccm::forms.input>
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                <x-ccm::forms.form>
                    <div class="border border-gray-200 rounded p-4 mt-2">
                        <h2>Bezoekadres</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <x-ccm::forms.input name="form.visiting_address" wire:model="form.visiting_address">
                                Adres
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.visiting_address_postcode"
                                                wire:model="form.visiting_address_postcode">
                                Postcode
                            </x-ccm::forms.input>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <x-ccm::forms.input name="form.visiting_address_city"
                                                wire:model="form.visiting_address_city">
                                Plaats
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.visiting_address_state"
                                                wire:model="form.visiting_address_state">
                                Provincie
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.visiting_address_country"
                                                wire:model="form.visiting_address_country">
                                Land
                            </x-ccm::forms.input>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded p-4 mt-2">
                        <h2>Postadres</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <x-ccm::forms.input name="form.visiting_address" wire:model="form.post_address">
                                Adres
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.post_address_postcode"
                                                wire:model="form.post_address_postcode">
                                Postcode
                            </x-ccm::forms.input>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <x-ccm::forms.input name="form.post_address_city" wire:model="form.post_address_city">
                                Plaats
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.post_address_state" wire:model="form.post_address_state">
                                Provincie
                            </x-ccm::forms.input>
                            <x-ccm::forms.input name="form.post_address_country" wire:model="form.post_address_country">
                                Land
                            </x-ccm::forms.input>
                        </div>
                    </div>

                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::forms.form>
                    <x-ccm::forms.input name="form.name" wire:model="form.name">
                        Gebruikersnaam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input type="password" name="form.password" wire:model="form.password">
                        Nieuw wachtwoord
                    </x-ccm::forms.input>
                    <x-ccm::forms.input type="password" name="form.password_confirmation"
                                        wire:model="form.password_confirmation">
                        Herhaal wachtwoord
                    </x-ccm::forms.input>
                    <x-ccm::forms.input-date name="form.expiration_date" wire:model="form.expiration_date">
                        Verloopdatum
                    </x-ccm::forms.input-date>
                    <x-ccm::forms.select name="form.is_active" wire:model="form.is_active" label="Actief">
                        <option value="1">Actief</option>
                        <option value="0">Niet actief</option>
                    </x-ccm::forms.select>

                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="3">
                <x-ccm::forms.form>
                    @foreach ($roles AS $role)
                        <x-ccm::forms.checkbox name="roles[]" wire:model="form.roles" value="{{ $role->id }}">
                            {{ $role->name }}
                        </x-ccm::forms.checkbox>
                    @endforeach
                </x-ccm::forms.form>
            </x-ccm::tabs.tab-content>
            {{--            <x-ccm::tabs.tab-content :index="4">--}}
            {{--                @foreach ($permissions AS $permission)--}}
            {{--                    <x-ccm::forms.checkbox name="form.permissions[]"--}}
            {{--                                           value="{{ $permission->id }}"--}}
            {{--                                           wire:model.live="form.permissions">--}}
            {{--                        {{ $permission->group }}.{{ $permission->name }}--}}
            {{--                        @if ($permission->description)--}}
            {{--                            ({{ $permission->description }})--}}
            {{--                        @endif--}}
            {{--                    </x-ccm::forms.checkbox>--}}
            {{--                @endforeach--}}
            {{--            </x-ccm::tabs.tab-content>--}}
            <x-ccm::tabs.tab-content :index="5" :no-margin="true">
                <x-ccm::tables.table :no-margin="true">
                    <x-slot:thead>
                        <x-ccm::tables.th :first="true">ID</x-ccm::tables.th>
                        <x-ccm::tables.th>Naam</x-ccm::tables.th>
                        <x-ccm::tables.th>Verloopt op</x-ccm::tables.th>
                        <x-ccm::tables.th>Laatst gebruikt</x-ccm::tables.th>
                        <x-ccm::tables.th :link="true"></x-ccm::tables.th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($user->tokens AS $token)
                            <x-ccm::tables.tr>
                                <x-ccm::tables.td>{{ $token->id }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $token->name }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $token->expires_at?->toDateTimeString() }}</x-ccm::tables.td>
                                <x-ccm::tables.td>{{ $token->last_used_at?->toDateTimeString() }}</x-ccm::tables.td>
                                <x-ccm::tables.td>
                                    <x-ccm::tables.delete-link
                                            wire:click="deleteToken({{ $token->id }})"
                                            wire:confirm="Weet je zeker dat je dit token wilt verwijderen?"
                                    ></x-ccm::tables.delete-link>
                                </x-ccm::tables.td>
                            </x-ccm::tables.tr>
                        @endforeach
                    </x-slot:tbody>
                </x-ccm::tables.table>

                <div class="flex flex-col gap-2 w-1/2 m-4">

                    <x-ccm::typography.h2>Nieuwe token toevoegen</x-ccm::typography.h2>
                    <x-ccm::forms.input name="apiForm.name" wire:model="apiForm.name" :required="true">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.input-datetime name="apiForm.expires_at" wire:model="apiForm.expires_at">
                        Verloopt op
                    </x-ccm::forms.input-datetime>

                    <x-ccm::typography.h3>Scopes</x-ccm::typography.h3>

                    <x-ccm::forms.select name="apiForm.allScopes" wire:model.live="apiForm.allScopes">
                        <option value="1">Alle rechten</option>
                        <option value="0">Specifieke rechten selecteren</option>
                    </x-ccm::forms.select>

                    @if (!$apiForm->allScopes)
                        @foreach ($scopes AS $scope => $description)
                            <x-ccm::forms.checkbox name="apiForm.scopes" wire:model="apiForm.scopes" :value="$scope">
                                {{ $scope }}<br>
                                <small>{{ $description }}</small>
                            </x-ccm::forms.checkbox>
                        @endforeach
                    @endif

                    <x-ccm::buttons.save wire:click="createToken">Token aanmaken</x-ccm::buttons.save>
                </div>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
