<?php

namespace Sellvation\CCMV2\Ccmp\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Sellvation\CCMV2\Ccmp\Jobs\ProcessStatisticsRowJob;
use Sellvation\CCMV2\CrmCards\Models\Builders\CrmFieldType;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Sellvation\CCMV2\Environments\Models\Environment;

class MigrateCcmpEnvironment extends Command
{
    protected $signature = 'ccmp:migrate-environment-data {--startdate=} {--remove}';

    protected $description = 'Stap 2: Migrate CCMp environment data, execute per environment';

    private $environmentId;

    private Environment $environment;

    private $emailCategoryIds = [];

    public function handle()
    {
        Config::set('database.connections.db01.database', 'ccmp');

        foreach (Environment::get() as $environment) {

            if ($this->confirm($environment->name.' importeren ?', true)) {
                $this->output->title('Import environment '.$environment->name);

                $this->environmentId = $environment->id;
                $this->environment = $environment;

                if ($this->option('remove')) {
                    $this->removeCrmCards();
                } else {
                    if ($this->confirm('Crm Fields importeren ?', true)) {
                        $this->migrateCrmFieldCategories();
                        $this->migrateCrmFields();
                    }
                    if ($this->confirm('Crm Card importeren ?', true)) {
                        $this->migrateCrmCards();
                    }
                    if ($this->confirm('E-mails importeren ?', false)) {
                        $this->migrateEmailCategories();
                        $this->migrateEmails();
                    }
                    if ($this->confirm('E-mail statistieken importeren ?', false)) {
                        $this->migrateEmailStats();
                    }

                    $this->cleanup();
                }
            }
        }
    }

    private function cleanup()
    {
        $this->info('Cleanup');

        CrmFieldCategory::query()
            ->whereEnvironmentId($this->environmentId)
            ->whereDoesntHave('crmFields')
            ->delete();
    }

    private function migrateCrmFieldCategories()
    {
        $this->info('Import crm field categories');

        $rows = \DB::connection('db01')
            ->table('rubrieken')
            ->where('omgevingen_id', $this->environmentId)
            ->get();

        foreach ($rows as $row) {
            $data = [
                'name' => $row->naamnl,
                'name_en' => $row->naamen,
                'name_de' => $row->naamde,
                'name_fr' => $row->naamfr,
                'is_visible' => $row->zichtbaar,
                'position' => $row->positie,
            ];

            $crmFieldCategory = $this->environment->crmFieldCategories()->updateOrCreate(['id' => $row->id], $data);
        }

        $this->info($this->environment->crmFieldCategories()->count().' crm field categories imported');
    }

    private function migrateCrmFields()
    {
        $this->info('Import fields');

        $rows = \DB::connection('db01')
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

        $rows = \DB::connection('db01')
            ->table('crm_velden')
            ->where('omgevingen_id', $this->environmentId)
            ->get();

        foreach ($rows as $row) {
            $field = $this->environment->crmFields()->updateOrCreate([
                'id' => $row->id,
            ], [
                'environment_id' => $this->environment->id,
                'crm_field_type_id' => $fieldTypes[$row->veldtype],
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

            try {
                $field->crmFieldCategory()->associate($row->rubrieken_id);
                $field->save();
            } catch (\Exception $e) {
            }
        }

        $this->info($this->environment->crmFields()->count().' fields imported');
    }

    private function getCrmFieldCategoryId($rubriekId): ?int
    {
        if ($rubriekId) {
            $row = \DB::connection('db01')
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

        if ($this->hasOption('startdate')) {
            $startDate = Carbon::parse($this->option('startdate'))->toDateTimeString();
        } else {
            $startDate = $this->ask('Wijzigingen vanaf welke datum (YYYY-MM-DD HH:mm:ii) ? ', now()->subMinutes(70)->toDateTimeString());
        }

        $progressBar = $this->output->createProgressBar(
            \DB::connection('db01')
                ->table('crm_'.$this->environmentId)
                ->where('datummutatie', '>=', $startDate)
                ->count()
        );

        \DB::connection('db01')
            ->table('crm_'.$this->environmentId)
            ->where('datummutatie', '>=', $startDate)
            ->orderBy('datummutatie')
            ->chunk(500, function ($crmCards) use ($progressBar) {
                foreach ($crmCards as $key => $row) {
                    if ($key === 0) {
                        $this->output->info($row->datummutatie);
                    }
                    $progressBar->advance();

                    $data = json_decode(json_encode($row), true);
                    $data = \Arr::except($data, [
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
                        'first_email_send_at' => Carbon::parse($row->eerste_email)->timezone('Europe/Amsterdam'),
                        'latest_email_send_at' => Carbon::parse($row->laatste_email)->timezone('Europe/Amsterdam'),
                        'first_email_opened_at' => Carbon::parse($row->eerste_email_geopend)->timezone('Europe/Amsterdam'),
                        'latest_email_opened_at' => Carbon::parse($row->laatste_email_geopend)->timezone('Europe/Amsterdam'),
                        'first_email_clicked_at' => Carbon::parse($row->eerste_email_geklikt)->timezone('Europe/Amsterdam'),
                        'latest_email_clicked_at' => Carbon::parse($row->laatste_email_geklikt)->timezone('Europe/Amsterdam'),
                        'first_visit_at' => Carbon::parse($row->eerste_bezoek)->timezone('Europe/Amsterdam'),
                        'latest_visit_at' => Carbon::parse($row->laatste_bezoek)->timezone('Europe/Amsterdam'),
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
                        'created_at' => Carbon::parse($row->datumcreatie)->timezone('Europe/Amsterdam'),
                        'updated_at' => Carbon::parse($row->datummutatie)->timezone('Europe/Amsterdam'),
                    ]);

                }
            });

        $progressBar->finish();
    }

    private function removeCrmCards()
    {
        $this->info('Remove CRM Card which don\'t exists anymore at CCMP.');

        $total = CrmCard::count();
        $bar = $this->output->createProgressBar($total);

        $deleted = 0;
        foreach (CrmCard::select(['id', 'crm_id'])->cursor() as $crmCard) {
            if (! \DB::connection('db01')
                ->table('crm_'.$this->environmentId)
                ->where('crmid', $crmCard->crm_id)
                ->exists()) {
                $crmCard->delete();
                $deleted++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->output->text($deleted.' of '.$total.' CRM Cards were removed.');
    }

    private function migrateEmailCategories()
    {
        $this->info('Import e-mail categories');

        $rows = \DB::connection('db01')
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

            $emailCategory = $this->environment
                ->emailCategories()
                ->firstOrCreate([
                    'name' => $row->naamnl,
                ], $data);
            $this->emailCategoryIds[$row->id] = $emailCategory->id;
        }

        $this->info($this->environment->emailCategories()->count().' e-mail categories imported');
    }

    private function migrateEmails()
    {
        $this->info('Import e-mails');

        \DB::table('emails')->delete();

        $rows = \DB::connection('db01')
            ->table('emails')
            ->where('omgevingen_id', $this->environmentId)
            ->orderBy('id')
            ->chunk(10, function ($rows) {
                foreach ($rows as $row) {
                    $recipientCrmFieldId = null;
                    if (preg_match('/\\[crmdata:[A-Za-z]+\\]/i', $row->ontvanger)) {
                        $recipientType = 'CRMFIELD';
                        $recipient = null;

                        preg_match('/\\[crmdata:(?<column>[^:]+)+\\]/i', $row->ontvanger, $matches);

                        if ($crmField = $this->environment
                            ->crmFields()
                            ->whereName($matches['column'])
                            ->first()) {
                            $recipientCrmFieldId = $crmField->id;
                        }

                    } else {
                        $recipientType = 'TEXT';
                        $recipient = $row->ontvanger;
                    }

                    $data = [
                        'environment_id' => $this->environment->id,
                        'email_category_id' => $row->rubrieken_id ? $this->emailCategoryIds[$row->rubrieken_id] : null,
                        'recipient_crm_field_id' => $recipientCrmFieldId,
                        'name' => $row->naam,
                        'description' => $row->omschrijving,
                        'sender_email' => $row->afzender,
                        'sender_name' => $row->afzenderomschrijving,
                        'recipient_type' => $recipientType,
                        'recipient' => $recipient,
                        'reply_to' => $row->antwoorden,
                        'subject' => $row->onderwerp,
                        'optout_url' => $row->afmeldurl,
                        'html' => $row->html,
                        'html_type' => $row->html_type,
                        'text' => $row->text,
                        'utm_code' => $row->code,
                        'is_locked' => (bool) $row->is_vergrendeld,
                        'stripo_html' => $row->stripo_html,
                        'stripo_css' => $row->stripo_css,
                        'is_template' => (bool) $row->is_template,
                        'created_at' => $row->datum,
                        'updated_at' => $row->datum,
                    ];

                    $email = $this->environment->emails()->updateOrCreate([
                        'id' => $row->id,
                    ], $data);
                }
            });

        $this->info($this->environment->emails()->count().' e-mail imported');
    }

    private function migrateEmailStats()
    {
        $this->info('Import crm_statistieken_xxx');

        \DB::table('email_statistics')->delete();

        $bar = $this->output->createProgressBar(CrmCard::count());

        \DB::connection('db01')
            ->table('crm_statistieken_'.$this->environmentId)
            ->select([
                'crm_id',
                'email_verzonden',
                'email_gebounced',
                'email_geopend',
                'email_geklikt',
            ])
            ->orderBy('crm_id')
            ->chunk(5000, function ($rows) use ($bar) {
                foreach ($rows as $row) {
                    $bar->advance();
                    ProcessStatisticsRowJob::dispatch($this->environmentId, $row);
                }
            });

        $bar->finish();
    }
}
