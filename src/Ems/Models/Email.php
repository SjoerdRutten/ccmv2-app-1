<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sellvation\CCMV2\Ccm\Models\TrackableLink;
use Sellvation\CCMV2\Ccm\Models\TrackablePixelOpen;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Ems\Enums\EmailType;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Sites\Models\Site;

class Email extends Model
{
    use HasEnvironment;

    const STRIPO = 'STRIPO';

    const HTML = 'HTML';

    protected $fillable = [
        'id',
        'site_id',
        'email_category_id',
        'recipient_crm_field_id',
        'name',
        'type',
        'description',
        'pre_header',
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
        'updated_at',
        'created_at',
    ];

    protected function casts()
    {
        return [
            'type' => EmailType::class,
            'is_locked' => 'bool',
            'is_template' => 'bool',
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function emailCategory(): BelongsTo
    {
        return $this->belongsTo(EmailCategory::class);
    }

    public function recipientCrmField(): BelongsTo
    {
        return $this->belongsTo(CrmField::class, 'recipient_crm_field_id');
    }

    public function trackableLinks(): MorphMany
    {
        return $this->morphMany(TrackableLink::class, 'trackable');
    }

    public function trackablePixelOpens(): MorphMany
    {
        return $this->morphMany(TrackablePixelOpen::class, 'trackable');
    }

    public function getCompiledHtml(CrmCard $crmCard, bool $tracking = false, bool $online = false): string
    {
        return \EmailCompiler::compile($this, $crmCard, $tracking, $online);
    }

    protected function stripoHtml(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => empty($value) ? file_get_contents(__DIR__.'/../stubs/stripo_html.stub') : $value,
        );
    }

    protected function stripoCss(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => empty($value) ? file_get_contents(__DIR__.'/../stubs/stripo_css.stub') : $value,
        );
    }
}
