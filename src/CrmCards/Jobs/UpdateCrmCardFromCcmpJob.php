<?php

namespace Sellvation\CCMV2\CrmCards\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Sellvation\CCMV2\Environments\Models\Environment;

class UpdateCrmCardFromCcmpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Environment $environment;

    public function __construct(private string $crmId)
    {
        $this->queue = 'ccmp';

        $this->environment = Environment::find(\Context::get('environment_id'));
    }

    public function handle(): void
    {
        Config::set('database.connections.db01.database', 'ccmp');
        \DB::purge('db01');

        $crmCard = \DB::connection('db01')
            ->table('crm_'.$this->environment->id)
            ->where('crmid', $this->crmId)
            ->first();

        $data = json_decode(json_encode($crmCard), true);
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

        \DB::beginTransaction();

        try {
            $this->environment->crmCards()->updateOrCreate([
                'crm_id' => $crmCard->crmid,
            ], [
                'crm_id' => $crmCard->crmid,
                'environment_id' => $this->environment->id,
                'updated_by_user_id' => null,
                'created_by_user_id' => null,
                'updated_by_api_id' => null,
                'first_ip' => $crmCard->eersteip,
                'latest_ip' => $crmCard->laatsteip,
                'first_ipv6' => $crmCard->eersteipv6,
                'latest_ipv6' => $crmCard->laatsteipv6,
                'browser_ua' => $crmCard->browser_ua,
                'first_email_send_at' => Carbon::parse($crmCard->eerste_email)->timezone('GMT'),
                'latest_email_send_at' => Carbon::parse($crmCard->laatste_email)->timezone('GMT'),
                'first_email_opened_at' => Carbon::parse($crmCard->eerste_email_geopend)->timezone('GMT'),
                'latest_email_opened_at' => Carbon::parse($crmCard->laatste_email_geopend)->timezone('GMT'),
                'first_email_clicked_at' => Carbon::parse($crmCard->eerste_email_geklikt)->timezone('GMT'),
                'latest_email_clicked_at' => Carbon::parse($crmCard->laatste_email_geklikt)->timezone('GMT'),
                'first_visit_at' => Carbon::parse($crmCard->eerste_bezoek)->timezone('GMT'),
                'latest_visit_at' => Carbon::parse($crmCard->laatste_bezoek)->timezone('GMT'),
                'browser' => $crmCard->browser,
                'browser_device_type' => $crmCard->browser_devicetype,
                'browser_device' => $crmCard->browser_device,
                'browser_os' => $crmCard->browser_os,
                'mailclient_ua' => $crmCard->mailclient_ua,
                'mailclient' => $crmCard->mailclient,
                'mailclient_device_type' => $crmCard->mailclient_devicetype,
                'mailclient_device' => $crmCard->mailclient_device,
                'mailclient_os' => $crmCard->mailclient_os,
                'latitude' => $crmCard->latitude,
                'longitude' => $crmCard->longitude,
                'data' => $data,
                'created_at' => Carbon::parse($crmCard->datumcreatie)->timezone('GMT'),
                'updated_at' => Carbon::parse($crmCard->datummutatie)->timezone('GMT'),
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
        }
        \DB::commit();

        \DB::disconnect('db01');
    }
}
