<?php

namespace Sellvation\CCMV2\Ems\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Mailing extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'ab_mailing_id',
        'email_id',
        'target_group_id',
        'email_category_id',
        'user_id',
        'name',
        'description',
        'start_at',
        'sending_started_at',
        'sending_ready_at',
        'sending_speed',
        'status',
        'archive_status',
        'ab_test_group',
        'mail_count',
        'send_confirmation',
        'confirmation_email_addresses',
        'has_confirmation_been_send',
        'send_reports',
        'reports_email_addresses',
        'is_reports_send',
        'is_hidden',
        'has_been_notified',
        'has_been_executed_multiple_times',
        'has_been_notified_bounce_rate',
    ];

    protected $casts = [
        'has_confirmation_been_send' => 'boolean',
        'is_reports_send' => 'boolean',
        'is_hidden' => 'boolean',
        'has_been_notified' => 'boolean',
        'has_been_executed_multiple_times' => 'boolean',
        'has_been_notified_bounce_rate' => 'boolean',
        'start_at' => 'datetime',
        'sending_started_at' => 'datetime',
        'sending_ready_at' => 'datetime',
    ];

    public function abMailing(): BelongsTo
    {
        return $this->belongsTo(Mailing::class);
    }

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }

    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(TargetGroup::class);
    }

    public function emailCategory(): BelongsTo
    {
        return $this->belongsTo(EmailCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
