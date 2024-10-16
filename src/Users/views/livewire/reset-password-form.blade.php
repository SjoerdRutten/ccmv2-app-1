<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white">
    <div>
        <a href="https://sellvation.nl">
            <img class="w-auto" src="{{ asset('assets/logo_ccmp.jpg') }}" alt="Sellvation">
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
        <x-ccm::forms.form method="post" wire:submit="store">
            @csrf
            <x-ccm::forms.input-hidden name="token" wire:model="token"/>
            <x-ccm::forms.input name="name" wire:model="name"
                                required
                                autofocus
                                autocomplete="username"
                                class="mb-4">
                Gebruikersnaam
            </x-ccm::forms.input>
            <x-ccm::forms.input type="password" name="password" wire:model="password"
                                required
                                autofocus
                                autocomplete="">
                Wachtwoord
            </x-ccm::forms.input>
            <x-ccm::forms.input type="password" name="password_confirmation" wire:model="password_confirmation"
                                required
                                autofocus
                                autocomplete="">
                Herhaal wachtwoord
            </x-ccm::forms.input>
            <div class="flex items-center justify-end mt-4">
                <x-ccm::buttons.primary>
                    Wachtwoord instellen
                </x-ccm::buttons.primary>
            </div>
        </x-ccm::forms.form>
    </div>
</div>