<?php

namespace Sellvation\CCMV2\CcmV1\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldType;
use Sellvation\CCMV2\Environments\Models\Environment;

class MigrateCcmV1Environment extends Command
{
    protected $signature = 'ccmv1:migrate-environment-data {--exportId=} {--importId=}';

    protected $description = 'Stap 2: Migrate CCM V1 environment data, execute per environment';

    private $environmentId;

    private Environment $environment;

    private $crmFieldCategoryIds = [];

    private $emailCategoryIds = [];

    public function handle()
    {
        Log::info('Import Environment Data From '.$this->option('exportId').' to '.$this->option('importId'));

        Config::set('database.connections.db02.database', 'ccmp');

        $this->environmentId = $this->option('exportId');
        $environmentId = $this->option('importId');

        if ($this->environment = Environment::find($environmentId)) {
            if ($this->confirm('CrmFields importeren ?', false)) {
                $this->migrateCrmFieldCategories();
                $this->migrateCrmFields();
            }
            if ($this->confirm('CrmCards importeren ?', false)) {
                $this->migrateCrmCards();
            }
            if ($this->confirm('Emails importeren ?', true)) {
                $this->migrateEmailCategories();
            }

            $this->cleanup();

        }
    }

    private function cleanup()
    {
        $this->info('Cleanup');

        CrmFieldCategory::query()
            ->whereDoesntHave('crmFields')
            ->delete();
    }

    private function migrateCrmFieldCategories()
    {
        $this->info('Import crm field categories');

        $rows = \DB::connection('db02')
            ->table('rubrieken')
            ->where('omgevingen_id', $this->environmentId)
            ->get();

        $this->crmFieldCategoryIds = [];
        foreach ($rows as $row) {
            $data = [
                'name' => $row->naamnl,
                'name_en' => $row->naamen,
                'name_de' => $row->naamde,
                'name_fr' => $row->naamfr,
                'is_visible' => $row->zichtbaar,
                'position' => $row->positie,
            ];

            $crmFieldCategory = $this->environment->crmFieldCategories()->firstOrCreate(['name' => $row->naamnl, $data], $data);
            $this->crmFieldCategoryIds[$row->id] = $crmFieldCategory->id;
        }

        $this->info($this->environment->crmFieldCategories()->count().' crm field categories imported');
    }

    private function migrateCrmFields()
    {
        $this->info('Import fields');

        $rows = \DB::connection('db02')
            ->table('crm_velden')
            ->select('veldtype')
            ->distinct()
            ->get();

        $fieldTypes = [];
        foreach ($rows as $row) {
            $crmField = CrmFieldType::firstOrCreate([
                'name' => $row->veldtype,
            ], [
                'label' => $row->veldtype,
            ]);

            $fieldTypes[$row->veldtype] = $crmField->id;
        }

        $rows = \DB::connection('db02')
            ->table('crm_velden')
            ->where('omgevingen_id', $this->environmentId)
            ->get();

        foreach ($rows as $row) {
            $this->environment->crmFields()->updateOrCreate([
                'name' => $row->naam,
            ], [
                'environment_id' => $this->environment->id,
                'crm_field_type_id' => $fieldTypes[$row->veldtype],
                'crm_field_category_id' => empty($row->rubrieken_id) ? null : $this->crmFieldCategoryIds[$row->rubrieken_id],
                'name' => $row->naam,
                'label' => $row->labelnl,
                'label_en' => $row->labelen,
                'label_de' => $row->labelde,
                'label_fr' => $row->labelfr,
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
            $row = \DB::connection('db02')
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

        $skip = CrmCard::count();

        $progressBar = $this->output->createProgressBar(
            \DB::connection('db02')
                ->table('crm_'.$this->environmentId)
                ->count()
        );

        \DB::connection('db02')
            ->table('crm_'.$this->environmentId)
            ->skip($skip)
            ->orderBy('datummutatie')
            ->chunk(1000, function ($crmCards) use ($progressBar) {
                foreach ($crmCards as $row) {
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

                    $this->environment->crmCards()->updateOrCreate([
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
            });

        $progressBar->finish();
    }

    private function migrateEmailCategories()
    {
        $this->info('Import e-mail categories');

        $rows = \DB::connection('db02')
            ->table('rubrieken')
            ->where('omgevingen_id', $this->environmentId)
            ->get();

        $this->emailCategoryIds = [];
        foreach ($rows as $row) {
            $data = [
                'name' => $row->naamnl,
                'name_en' => $row->naamen,
                'name_de' => $row->naamde,
                'name_fr' => $row->naamfr,
                'is_visible' => $row->zichtbaar,
                'position' => $row->positie,
            ];

            $emailCategory = $this->environment->emailCategories()->firstOrCreate(['name' => $row->naamnl, $data], $data);
            $this->emailCategoryIds[$row->id] = $emailCategory->id;
        }

        $this->info($this->environment->emailCategories()->count().' e-mail categories imported');
    }
}
