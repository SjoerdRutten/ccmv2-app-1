<?php

namespace Sellvation\CCMV2\CcmV1\Console\Commands;

use Sellvation\CCMV2\Environments\Models\Environment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MigrateCcmV1Environment extends Command
{
    protected $signature = 'ccmv1:migrate-environment-data';

    protected $description = 'Stap 2: Migrate CCM V1 environment data, execute per environment';

    private $environmentId;

    private Environment $environment;

    public function handle()
    {
        $this->environmentId = $this->ask('Welke omgeving ID wil je importeren ?', 105);
        $environmentId = $this->ask('In welke environment ID wil je de data importeren ?', 5);

        if ($this->environment = Environment::find($environmentId)) {
            $this->migrateCrmFieldCategories();
            $this->migrateCrmFields();
            $this->migrateCrmCards();
        }

        // TODO: Import details + parameters
    }

    private function migrateCrmFieldCategories()
    {
        $this->info('Import categories');

        $rows = \DB::connection('mysqlv1')
            ->table('rubrieken')
            ->where('omgevingen_id', $this->environmentId)
            ->get();

        foreach ($rows as $row) {
            $this->environment->crmFieldCategories()->firstOrCreate([
                'name' => $row->naamnl,
            ], [
                'name' => $row->naamnl,
                'name_en' => $row->naamen,
                'name_de' => $row->naamde,
                'name_fr' => $row->naamfr,
                'is_visible' => $row->zichtbaar,
                'position' => $row->positie,
            ]);
        }

        $this->info($this->environment->crmFieldCategories()->count().' categories imported');
    }

    private function migrateCrmFields()
    {
        $this->info('Import fields');

        $rows = \DB::connection('mysqlv1')
            ->table('crm_velden')
            ->where('omgevingen_id', $this->environmentId)
            ->get();

        foreach ($rows as $row) {
            $this->environment->crmFields()->updateOrCreate([
                'name' => $row->naam,
            ], [
                'crm_field_category_id' => $this->getCrmFieldCategoryId($row->rubrieken_id),
                'name' => $row->naam,
                'label' => $row->labelnl,
                'label_en' => $row->labelen,
                'label_de' => $row->labelde,
                'label_fr' => $row->labelfr,
                'type' => $row->veldtype,
                'is_shown_on_overview' => $row->overzicht,
                'is_hidden' => $row->verbergen,
                'is_locked' => $row->vergrendelen,
                'position' => (int) $row->positie,
                'log_file' => $row->logbestand,
                'overview_index' => $row->overzichtindex,
            ]);
        }

        $this->info($this->environment->crmFields()->count().' fields imported');
    }

    private function getCrmFieldCategoryId($rubriekId): ?int
    {
        if ($rubriekId) {
            $row = \DB::connection('mysqlv1')
                ->table('rubrieken')
                ->select(['id'])
                ->where('id', $rubriekId)
                ->first();

            return $row->id;
        }

        return null;
    }

    private function migrateCrmCards()
    {
        $this->info('Import CRM Cards');

        $progressBar = $this->output->createProgressBar(
            \DB::connection('mysqlv1')
                ->table('crm_'.$this->environmentId)
                ->count()
        );

        foreach (\DB::connection('mysqlv1')
            ->table('crm_'.$this->environmentId)
            ->cursor() as $row) {
            $progressBar->advance();

            $data = json_decode(json_encode($row), true);
            $data = \Arr::except($data, [
                'id',
                'crmid',
                'systeemgebruiker',
                'systeemwachtwoord',
                'datumcreatie',
                'datummutatie',
                'bewerkt_door_gebruikers_id',
                'bewerkt_door_api_id',
                'aangemaakt_door_gebruikers_id',
                'eersteip',
                'laatsteip',
                'eersteipv6',
                'laatsteipv6',
                'browser_ua',
                'eerste_email',
                'laatste_email',
                'eerste_email_geopend',
                'laatste_email_geopend',
                'eerste_email_geklikt',
                'laatste_email_geklikt',
                'eerste_bezoek',
                'laatste_bezoek',
                'browser',
                'browser_devicetype',
                'browser_device',
                'browser_os',
                'mailclient_ua',
                'mailclient',
                'mailclient_device',
                'mailclient_devicetype',
                'mailclient_os',
                'latitude',
                'longitude',
            ]);

            $this->environment->crmCards()->createOrFirst([
                'environment_id' => $this->environment->id,
                'crm_id' => $row->crmid,
            ], [
                'crm_id' => $row->crmid,
                'environment_id' => $this->environment->id,
                'updated_by_user_id' => null,
                'created_by_user_id' => null,
                'updated_by_api_id' => null,
                'first_ip' => $row->eersteip,
                'latest_ip' => $row->laatsteip,
                'first_ipv6' => $row->eersteipv6,
                'latest_ipv6' => $row->laatsteipv6,
                'browser_ua' => $row->browser_ua,
                'first_email_send_at' => Carbon::parse($row->eerste_email),
                'latest_email_send_at' => Carbon::parse($row->laatste_email),
                'first_email_opened_at' => Carbon::parse($row->eerste_email_geopend),
                'latest_email_opened_at' => Carbon::parse($row->laatste_email_geopend),
                'first_email_clicked_at' => Carbon::parse($row->eerste_email_geklikt),
                'latest_email_clicked_at' => Carbon::parse($row->laatste_email_geklikt),
                'first_visit_at' => Carbon::parse($row->eerste_bezoek),
                'latest_visit_at' => Carbon::parse($row->laatste_bezoek),
                'browser' => $row->browser,
                'browser_device_type' => $row->browser_devicetype,
                'browser_device' => $row->browser_device,
                'browser_os' => $row->browser_os,
                'mailclient_ua' => $row->mailclient_ua,
                'mailclient' => $row->mailclient,
                'mailclient_device_type' => $row->mailclient_devicetype,
                'mailclient_device' => $row->mailclient_device,
                'mailclient_os' => $row->mailclient_os,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude,
                'data' => $data,
                'created_at' => $row->datumcreatie,
                'updated_at' => $row->datummutatie,
            ]);

        }

        $progressBar->finish();
    }
}
