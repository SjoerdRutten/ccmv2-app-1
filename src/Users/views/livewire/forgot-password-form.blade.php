<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white">
    <div>
        <a href="https://sellvation.nl">
            <img class="w-auto" src="{{ asset('assets/logo_ccmp.jpg') }}" alt="Sellvation">
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 text-sm text-gray-600">
            Wachtwoord vergeten ? Geen probleem. Geef je gebruikersnaam en we sturen een e-mail met een reset link naar
            het gekoppelde e-mailadres zodat je een nieuw wachtwoord kan aanmaken.
        </div>
        <x-ccm::forms.form method="post" wire:submit="store">
            @csrf
            <x-ccm::forms.input name="name" wire:model="name" required autofocus autocomplete="username"
                                class="mb-4">
                Gebruikersnaam
            </x-ccm::forms.input>
            <div class="flex items-center justify-end mt-4">
                <x-ccm::buttons.primary>
                    E-mail reset link
                </x-ccm::buttons.primary>
            </div>
        </x-ccm::forms.form>
    </div>
</div>