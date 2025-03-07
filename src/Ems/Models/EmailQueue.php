<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Ccm\Traits\HasTrackedJobs;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Events\EmailQueueCreatedEvent;
use Sellvation\CCMV2\Ems\Events\EmailQueueCreatingEvent;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class EmailQueue extends Model
{
    use HasTrackedJobs;

    protected $fillable = [
        'email_id',
        'crm_card_id',
        'mail_server_id',
        'start_sending_at',
        'to_name',
        'to_email',
        'from_name',
        'from_email',
        'subject',
        'content',
        'domain',
        'message_id',
        'queued_at',
        'send_at',
        'error_at',
        'bounce',
        'bounced_at',
        'abuse',
        'abused_at',
    ];

    protected $casts = [
        'start_sending_at' => 'datetime',
        'queued_at' => 'datetime',
        'send_at' => 'datetime',
        'error_at' => 'datetime',
        'bounce_at' => 'datetime',
        'abused_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'creating' => EmailQueueCreatingEvent::class,
        'created' => EmailQueueCreatedEvent::class,
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }

    public function mailServer(): BelongsTo
    {
        return $this->belongsTo(MailServer::class);
    }
}
