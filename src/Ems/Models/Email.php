<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Email extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'email_category_id',
        'recipient_crm_field_id',
        'name',
        'description',
        'sender_email',
        'sender_name',
        'recipient_type',
        'recipient',
        'reply_to',
        'subject',
        'optout_url',
        'stripo_html',
        'stripo_css',
        'html',
        'html_type',
        'text',
        'utm_code',
        'is_locked',
        'is_template',
    ];

    protected function casts()
    {
        return [
            'is_locked' => 'bool',
            'is_template' => 'bool',
        ];
    }

    public function emails(): BelongsTo
    {
        return $this->belongsTo(EmailCategory::class);
    }
}
