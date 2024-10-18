<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white">
    <div>
        <a href="https://sellvation.nl">
            <img class="w-auto" src="{{ asset('assets/logo_ccmp.jpg') }}" alt="Sellvation">
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
        <x-ccm::forms.form method="post" action="{{ route('login') }}">
            @csrf
            <x-ccm::forms.input name="name" :value="old('name')" required autofocus autocomplete="username"
                                class="mb-4">
                Gebruikersnaam
            </x-ccm::forms.input>
            <x-ccm::forms.input type="password" name="password" :value="old('password')" required autofocus
                                autocomplete="current-password">
                Wachtwoord
            </x-ccm::forms.input>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                   href="{{ route('password.request') }}">
                    Wachtwoord vergeten?
                </a>

                <x-ccm::buttons.primary>
                    Inloggen
                </x-ccm::buttons.primary>
            </div>
        </x-ccm::forms.form>
    </div>
</div>
