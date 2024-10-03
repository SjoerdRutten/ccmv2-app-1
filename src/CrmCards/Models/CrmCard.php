<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class CrmCard extends Model
{
    use HasEnvironment;
    use Searchable;

    protected $fillable = [
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

    public function searchableAs()
    {
        if ($this->environment_id) {
            $environmentId = $this->environment_id;
        } elseif (app()->runningInConsole()) {
            $environmentId = config('ccm.environment_id');
        } else {
            $environmentId = \Auth::check() ? \Auth::user()->currentEnvironmentId : $this->environment_id;
        }

        return $this->getTable().'_'.$environmentId;
    }

    public function indexableAs()
    {
        return $this->searchableAs();
    }

    public function toSearchableArray()
    {
        $data = [
            'id' => (string) $this->id,
            'crm_id' => $this->crm_id,
            'updated_at' => $this->updated_at->timestamp,
            'created_at' => $this->created_at->timestamp,
            'first_email_send_at' => $this->first_email_send_at ? Carbon::parse($this->first_email_send_at)->timestamp : null,
            'latest_email_send_at' => $this->latest_email_send_at ? Carbon::parse($this->latest_email_send_at)->timestamp : null,
            'first_email_opened_at' => $this->first_email_opened_at ? Carbon::parse($this->first_email_opened_at)->timestamp : null,
            'latest_email_opened_at' => $this->latest_email_opened_at ? Carbon::parse($this->latest_email_opened_at)->timestamp : null,
            'first_email_clicked_at' => $this->first_email_clicked_at ? Carbon::parse($this->first_email_clicked_at)->timestamp : null,
            'latest_email_clicked_at' => $this->latest_email_clicked_at ? Carbon::parse($this->latest_email_clicked_at)->timestamp : null,
            'first_visit_at' => $this->first_visit_at ? Carbon::parse($this->first_visit_at)->timestamp : null,
            'latest_visit_at' => $this->latest_visit_at ? Carbon::parse($this->latest_visit_at)->timestamp : null,
            'browser_ua' => $this->browser_ua,
            'browser' => $this->browser,
            'browser_device_type' => $this->browser_device_type,
            'browser_device' => $this->browser_device,
            'browser_os' => $this->browser_os,
            'mailclient_ua' => $this->mailclient_ua,
            'mailclient' => $this->mailclient,
            'mailclient_device_type' => $this->mailclient_device_type,
            'mailclient_device' => $this->mailclient_device,
            'mailclient_os' => $this->mailclient_os,
        ];

        foreach (
            CrmField::whereEnvironmentId($this->environment_id)
                ->whereIsShownOnTargetGroupBuilder(1)
                ->get() as $crmField
        ) {
            switch ($crmField->type) {
                case 'BOOLEAN':
                case 'CONSENT':
                    $data[$crmField->name] = (bool) \Arr::get($this->data, $crmField->name);
                    break;
                case 'DATETIME':
                    $data[$crmField->name] = $this->makeTimestamp(\Arr::get($this->data, $crmField->name));

                    break;
                case 'DECIMAL':
                    $data[$crmField->name] = (float) \Arr::get($this->data, $crmField->name);
                    break;
                case 'INT':
                    $data[$crmField->name] = (int) \Arr::get($this->data, $crmField->name);
                    break;
                case 'EMAIL':
                    $data['_'.$crmField->name.'_abuse'] = (bool) \Arr::get($this->data, $crmField->name.'_abuse');
                    $data['_'.$crmField->name.'_abuse_timestamp'] = $this->makeTimestamp(\Arr::get($this->data, $crmField->name.'_abuse_timestamp'));
                    $data['_'.$crmField->name.'_bounce_reason'] = \Arr::get($this->data, $crmField->name.'_bounce_reason');
                    $data['_'.$crmField->name.'_bounce_score'] = (int) \Arr::get($this->data, $crmField->name.'_bounce_score');
                    $data['_'.$crmField->name.'_bounce_type'] = \Arr::get($this->data, $crmField->name.'_bounce_type');
                    $data['_'.$crmField->name.'_type'] = \Arr::get($this->data, $crmField->name.'_type');
                    break;
                case 'MEDIA':
                    $data['_'.$crmField->name.'_optin'] = (bool) \Arr::get($this->data, $crmField->name.'_optin');
                    $data['_'.$crmField->name.'_optin_timestamp'] = $this->makeTimestamp(\Arr::get($this->data, $crmField->name.'_optin_timestamp'));
                    $data['_'.$crmField->name.'_confirmed_optin'] = (bool) \Arr::get($this->data, $crmField->name.'_confirmed_optin');
                    $data['_'.$crmField->name.'_confirmed_optin_timestamp'] = $this->makeTimestamp(\Arr::get($this->data, $crmField->name.'_confirmed_optin_timestamp'));
                    $data['_'.$crmField->name.'_confirmed_optout'] = (bool) \Arr::get($this->data, $crmField->name.'_confirmed_optout');
                    $data['_'.$crmField->name.'_optout_timestamp'] = $this->makeTimestamp(\Arr::get($this->data, $crmField->name.'_optout_timestamp'));
                    break;
                default:
                    $data[$crmField->name] = \Arr::get($this->data, $crmField->name);

            }
        }

        return $data;
    }

    private function makeTimestamp($value)
    {
        if ($value) {
            try {
                $timestamp = Carbon::parse($value)->timestamp;

                return $timestamp === -62169984000 ? null : $timestamp;
            } catch (\Exception $e) {
            }
        }

        return null;
    }

    public function typesenseCollectionSchema()
    {
        $fields = [
            [
                'name' => 'id',
                'type' => 'string',
            ], [
                'name' => 'crm_id',
                'type' => 'string',
            ], [
                'name' => 'updated_at',
                'type' => 'int64',
            ], [
                'name' => 'created_at',
                'type' => 'int64',
            ], [
                'name' => 'first_email_send_at',
                'type' => 'int64',
            ], [
                'name' => 'latest_email_send_at',
                'type' => 'int64',
            ], [
                'name' => 'first_email_opened_at',
                'type' => 'int64',
            ], [
                'name' => 'latest_email_opened_at',
                'type' => 'int64',
            ], [
                'name' => 'first_email_clicked_at',
                'type' => 'int64',
            ], [
                'name' => 'latest_email_clicked_at',
                'type' => 'int64',
            ], [
                'name' => 'first_visit_at',
                'type' => 'int64',
            ], [
                'name' => 'latest_visit_at',
                'type' => 'int64',
            ], [
                'name' => 'browser_ua',
                'type' => 'string',
            ], [
                'name' => 'browser',
                'type' => 'string',
            ], [
                'name' => 'browser_device_type',
                'type' => 'string',
            ], [
                'name' => 'browser_device',
                'type' => 'string',
            ], [
                'name' => 'browser_os',
                'type' => 'string',
            ], [
                'name' => 'mailclient_ua',
                'type' => 'string',
            ], [
                'name' => 'mailclient',
                'type' => 'string',
            ], [
                'name' => 'mailclient_device_type',
                'type' => 'string',
            ], [
                'name' => 'mailclient_device',
                'type' => 'string',
            ], [
                'name' => 'mailclient_os',
                'type' => 'string',
            ],
        ];

        foreach (
            CrmField::whereEnvironmentId($this->environment_id)
                ->whereIsShownOnTargetGroupBuilder(1)
                ->get() as $crmField
        ) {
            switch ($crmField->type) {
                case 'BOOLEAN':
                case 'CONSENT':
                    $fieldType = 'bool';
                    break;
                case 'DATETIME':
                    $fieldType = 'int64';
                    break;
                case 'DECIMAL':
                    $fieldType = 'float';
                    break;
                case 'INT':
                    $fieldType = 'int32';
                    break;
                case 'MEDIA':
                    $fields[] = ['name' => '_'.$crmField->name.'_optin', 'type' => 'bool', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_optin_timestamp', 'type' => 'int64', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_confirmed_optin', 'type' => 'bool', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_confirmed_optin_timestamp', 'type' => 'int64', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_confirmed_optout', 'type' => 'bool', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_optout_timestamp', 'type' => 'int64', 'optional' => true];

                    $fieldType = false;
                    break;
                case 'EMAIL':
                    $fields[] = ['name' => $crmField->name, 'type' => 'string', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_abuse', 'type' => 'bool', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_abuse_timestamp', 'type' => 'int64', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_bounce_reason', 'type' => 'string', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_bounce_score', 'type' => 'int32', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_bounce_type', 'type' => 'string', 'optional' => true];
                    $fields[] = ['name' => '_'.$crmField->name.'_type', 'type' => 'string', 'optional' => true];

                    $fieldType = false;
                    break;
                case 'TEXTBIG':
                case 'TEXTMICRO':
                case 'TEXTMIDDLE':
                case 'TEXTMINI':
                case 'TEXTSMALL':
                default:
                    $fieldType = 'string';

            }

            if ($fieldType) {
                $fields[] = [
                    'name' => $crmField->name,
                    'type' => $fieldType,
                    'optional' => true,
                ];
            }
        }

        $fields[] = [
            'name' => '.*',
            'type' => 'auto',
        ];

        return [
            'fields' => $fields,
        ];
    }
}
