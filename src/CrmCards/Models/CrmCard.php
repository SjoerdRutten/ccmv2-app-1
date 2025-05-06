<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\CrmCards\Events\CrmCardCreatingEvent;
use Sellvation\CCMV2\CrmCards\Events\CrmCardDeletingEvent;
use Sellvation\CCMV2\CrmCards\Events\CrmCardSavedEvent;
use Sellvation\CCMV2\Ems\Models\Email;
use Sellvation\CCMV2\Ems\Models\EmailOptIn;
use Sellvation\CCMV2\Ems\Models\EmailOptOut;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Orders\Models\Order;
use Spatie\Tags\HasTags;

class CrmCard extends Model
{
    use HasEnvironment;
    use HasTags;

    protected $fillable = [
        'id',
        'updated_by_user_id',
        'created_by_user_id',
        'updated_by_api_id',
        'crm_id',
        'first_ip',
        'latest_ip',
        'first_ipv6',
        'latest_ipv6',
        'browser_ua',
        'first_email_send_at',
        'latest_email_send_at',
        'first_email_opened_at',
        'latest_email_opened_at',
        'first_email_clicked_at',
        'latest_email_clicked_at',
        'first_visit_at',
        'latest_visit_at',
        'browser',
        'browser_device_type',
        'browser_device',
        'browser_os',
        'mailclient_ua',
        'mailclient',
        'mailclient_device_type',
        'mailclient_device',
        'mailclient_os',
        'latitude',
        'longitude',
        'data',
        'updated_at',
        'created_at',
    ];

    protected $dispatchesEvents = [
        'creating' => CrmCardCreatingEvent::class,
        'saved' => CrmCardSavedEvent::class,
        'deleting' => CrmCardDeletingEvent::class,
    ];

    protected function casts(): array
    {
        return [
            'first_email_send_at' => 'datetime',
            'latest_email_send_at' => 'datetime',
            'first_email_opened_at' => 'datetime',
            'latest_email_opened_at' => 'datetime',
            'first_email_clicked_at' => 'datetime',
            'latest_email_clicked_at' => 'datetime',
            'first_visit_at' => 'datetime',
            'latest_visit_at' => 'datetime',
            'data' => 'json',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasmany(Order::class);
    }

    public function crmCardLogs(): HasMany
    {
        return $this->hasMany(CrmCardLog::class);
    }

    public function emailOptOuts(): HasMany
    {
        return $this->hasMany(EmailOptOut::class);
    }

    public function emailOptIns(): HasMany
    {
        return $this->hasMany(EmailOptIn::class);
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updatedByApi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_api_id');
    }

    public function optOut(Email $email, CrmField $crmField, ?string $reason = null, ?string $explanation = null): bool
    {
        $data = [];
        $data['_'.$crmField->name.'_optout_timestamp'] = now()->timestamp;

        $this->emailOptOuts()->create([
            'email_id' => $email->id,
            'crm_field_id' => $crmField->id,
            'ip' => request()->ip(),
            'reason' => $reason,
            'explanation' => $explanation,
        ]);

        return true;
    }

    public function getCookie()
    {
        return cookie('crmId', $this->crm_id, 60 * 24 * 365);
    }

    public function getData($key)
    {
        return \Arr::get($this->data, $key);
    }

    public function setData(array $input): array
    {
        $data = $this->data;

        $response = [
            'not_changed' => [],
            'success' => [],
        ];

        foreach ($input as $name => $value) {
            if (\Arr::get($data, $name) !== $value) {
                $response['success'][$name] = [
                    'old' => \Arr::get($data, $name),
                    'new' => $value,
                ];

                $data[$name] = $value;
            } else {
                $response['not_changed'][] = $name;
            }
        }

        $this->data = $data;

        if (($this->id) && (count($response['success']) > 0)) {
            $this->crmCardLogs()->create(['changes' => $response['success']]);
        }

        return $response;
    }
}
