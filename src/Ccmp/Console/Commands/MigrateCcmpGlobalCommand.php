<?php

namespace Sellvation\CCMV2\Ccmp\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Sellvation\CCMV2\Environments\Models\Environment;
use Sellvation\CCMV2\Environments\Models\Timezone;
use Sellvation\CCMV2\Users\Models\Customer;
use Sellvation\CCMV2\Users\Models\Role;
use Sellvation\CCMV2\Users\Models\User;

class MigrateCcmpGlobalCommand extends Command
{
    protected $signature = 'ccmv1:migrate-global';

    protected $description = 'Stap 1: Migrate CCM V1, only need to be executed once';

    private Customer $customer;

    public function handle()
    {
        Config::set('database.connections.db02.database', 'ccmp');

        $customers = \DB::connection('db02')
            ->table('klanten')
            ->select(['id', 'naam'])
            ->orderBy('naam', 'asc')
            ->pluck('naam', 'id');

        $this->migrateTimezones();
        if ($customerName = $this->choice('Select a customer', $customers->toArray(), 167)) {
            $this->migrateCustomers($customerName);
        }
        $this->migrateEnvironments();
        $this->migrateUsers();
    }

    private function splitAllowedIps($ips): array
    {
        $ips = explode(',', $ips);
        $allowedIps = [];
        foreach ($ips as $allowedIp) {
            $split = explode("\r\n", $allowedIp);
            $allowedIps = array_merge($allowedIps, $split);
        }
        \Arr::map($allowedIps, function ($ip) {
            return trim($ip);
        });
        $allowedIps = Arr::where($allowedIps, function ($ip) {
            return $ip !== '';
        });

        return $allowedIps;
    }

    private function migrateTimezones(): void
    {
        $this->info('Migrate timezones');

        $timezones = \DB::connection('db02')
            ->select('select * from tijdzones');

        foreach ($timezones as $timezone) {
            Timezone::updateOrCreate([
                'id' => $timezone->id,
            ], [
                'timezone' => $timezone->zone,
                'name' => $timezone->naam,
            ]);
        }

        $this->info(Timezone::count().' timezones migrated');
    }

    private function migrateUsers(): void
    {
        $this->info('Migrate users');

        $users = \DB::connection('db02')
            ->table('gebruikers')
            ->whereIn('klanten_id', [$this->customer->id, 1])
            ->get();

        $adminRole = Role::whereName('admin')->first();
        $userRole = Role::whereName('user')->first();

        $progressBar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            $progressBar->advance();

            $newUser = User::updateOrCreate([
                'id' => $user->id,
            ], [
                'customer_id' => $this->customer->id,
                'name' => $user->naam,
                'gender' => $user->sekse,
                'first_name' => $user->voornaam,
                'suffix' => $user->tussenvoegsel,
                'last_name' => $user->achternaam,
                'department' => $user->afdeling,
                'function' => $user->functie,
                'visiting_address' => $user->bezoekadres_adres,
                'visiting_address_postcode' => $user->bezoekadres_postcode,
                'visiting_address_city' => $user->bezoekadres_plaats,
                'visiting_address_state' => $user->bezoekadres_provincie,
                'visiting_address_country' => 'NL',
                'postal_address' => $user->postadres_adres,
                'postal_address_postcode' => $user->postadres_postcode,
                'postal_address_city' => $user->postadres_plaats,
                'postal_address_state' => $user->postadres_provincie,
                'postal_address_country' => 'NL',
                'email' => $user->emailadres,
                'telephone' => $user->telefoon,
                'fax' => $user->faxnummer,
                'password' => '',
                'old_password' => $user->wachtwoord,
                'screen_resolution' => $user->beeldscherm_resolutie,
                'rows' => $user->rijen,
                'first_login' => $user->eerstelogin != '0000-00-00 00:00:00' ? $user->eerstelogin : null,
                'last_login' => $user->laatstelogin != '0000-00-00 00:00:00' ? $user->laatstelogin : null,
                'expiration_date' => $user->verloopdatum != '0000-00-00 00:00:00' ? $user->verloopdatum : null,
                'is_active' => $user->actief,
                'is_system' => $user->systeem,
                'allowed_ips' => $this->splitAllowedIps($user->allowed_ips),
            ]);

            if ($user->klanten_id === 1) {
                $role = $adminRole;
            } else {
                $role = $userRole;
            }
            $newUser->roles()->sync([$role->id]);
        }

        $progressBar->finish();

        $this->info(User::count().' users migrated');
    }

    private function migrateCustomers($name): void
    {
        $this->info('Migrate customers');

        $customer = \DB::connection('db02')
            ->table('klanten')
            ->where('naam', '=', $name)
            ->select('*')
            ->first();

        $customer = Customer::updateOrCreate([
            'id' => $customer->id,
        ], [
            'name' => $customer->naam,
            'visiting_address' => $customer->bezoekadresadres,
            'visiting_address_postcode' => $customer->bezoekadrespostcode,
            'visiting_address_city' => $customer->bezoekadresplaats,
            'visiting_address_state' => $customer->bezoekadresprovincie,
            'visiting_address_country' => 'NL',
            'postal_address' => $customer->postadresadres,
            'postal_address_postcode' => $customer->postadrespostcode,
            'postal_address_city' => $customer->postadresplaats,
            'postal_address_state' => $customer->postadresprovincie,
            'postal_address_country' => 'NL',
            'telephone' => $customer->telefoon,
            'fax' => $customer->faxnummer,
            'email' => $customer->emailadres,
            'url' => $customer->website,
            'logo' => $customer->logo,
            'allowed_ips' => $this->splitAllowedIps($customer->allowed_ips),
        ]);

        $this->customer = $customer;
    }

    private function migrateEnvironments()
    {
        $this->info('Migrate environments');

        $environments = \DB::connection('db02')
            ->table('omgevingen')
            ->where('klanten_id', $this->customer->id)
            ->get();

        foreach ($environments as $environment) {
            if (! Environment::where('id', $environment->id)->exists()) {
                Environment::firstOrCreate([
                    'id' => $environment->id,
                ], [
                    'customer_id' => $this->customer->id,
                    'timezone_id' => $environment->tijdzones_id,
                    'name' => $environment->naam,
                    'description' => $environment->omschrijving,
                ]);
            }
        }

        $this->info(Environment::count().' environments migrated');
    }
}
