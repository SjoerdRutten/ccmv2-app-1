<?php

namespace Sellvation\CCMV2\CcmV1\Console\Commands;

use App\Models\Team;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Sellvation\CCMV2\Environments\Models\Environment;
use Sellvation\CCMV2\Environments\Models\Timezone;

class MigrateCcmV1Command extends Command
{
    protected $signature = 'ccmv1:migrate-global';

    protected $description = 'Stap 1: Migrate CCM V1, only need to be executed once';

    public function handle()
    {
        if ($this->confirm('Timezones migration')) {
            $this->migrateTimezones();
        }
        if ($this->confirm('Users migration')) {
            $this->migrateUsers();
        }
        if ($this->confirm('Customers migration')) {
            $this->migrateCustomers();
            $this->associateUsersToTeams();

        }
        if ($this->confirm('Environments migration', true)) {
            $this->migrateEnvironments();
        }
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

        $timezones = \DB::connection('mysqlv1')
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

        $users = \DB::connection('mysqlv1')
            ->select('select * from gebruikers');

        $progressBar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            $progressBar->advance();

            User::updateOrCreate([
                'id' => $user->id,
            ], [
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
        }

        $progressBar->finish();

        $this->info(User::count().' users migrated');
    }

    private function migrateCustomers(): void
    {
        $this->info('Migrate customers');

        $customers = \DB::connection('mysqlv1')
            ->select('select * from klanten');

        foreach ($customers as $customer) {
            Team::updateOrCreate([
                'id' => $customer->id,
            ], [
                'user_id' => 0,
                'personal_team' => 0,
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
        }

        $this->info(Team::count().' teams migrated');
    }

    private function associateUsersToTeams(): void
    {
        $this->info('Associate users to teams');

        $users = \DB::connection('mysqlv1')
            ->select('select id, klanten_id from gebruikers');

        foreach ($users as $oldUser) {
            if ($user = User::find($oldUser->id)) {
                $user->teams()->sync([$oldUser->klanten_id]);
                $user->current_team_id = $oldUser->klanten_id;
                $user->save();
            }
        }

        $customers = \DB::connection('mysqlv1')
            ->table('klanten')
            ->where('helpdesk_gebruikers_id', '<>', '')
            ->select(['id', 'helpdesk_gebruikers_id'])
            ->get();

        foreach ($customers as $customer) {
            if ($user = User::find($customer->helpdesk_gebruikers_id)) {
                $team = Team::find($customer->id);
                $team->helpdeskUser()->associate($user);
                $team->save();
            }
        }
    }

    private function migrateEnvironments()
    {
        $this->info('Migrate environments');

        $environments = \DB::connection('mysqlv1')
            ->select('select * from omgevingen');

        foreach ($environments as $environment) {
            Environment::createOrFirst([
                'id' => $environment->id,
            ], [
                'team_id' => $environment->klanten_id,
                'timezone_id' => $environment->tijdzones_id,
                'name' => $environment->naam,
                'description' => $environment->omschrijving,
                'email_credits' => $environment->emailtegoed,
                'notified' => $environment->notified,
            ]);
        }

        $this->info(Environment::count().' environments migrated');
    }
}
