<?php

namespace Sellvation\CCMV2\Ems\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sellvation\CCMV2\Ccm\Models\TrackableLink;
use Sellvation\CCMV2\Ccm\Models\TrackablePixelOpen;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Ems\Enums\EmailType;
use Sellvation\CCMV2\Ems\Events\EmailSavedEvent;
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

    protected $dispatchesEvents = [
        'saved' => EmailSavedEvent::class,
    ];

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

    public function emailQueues(): HasMany
    {
        return $this->hasMany(EmailQueue::class);
    }

    protected function html(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->html_type === Email::HTML ? $this->attributes['html'] : $this->attributes['stripo_html'],
        );
    }

    public function getCompiledHtml(CrmCard $crmCard, bool $tracking = false, bool $online = false): string
    {
        return \EmailCompiler::compile($this, $crmCard, $tracking, $online);
    }

    public function getCompiledText(CrmCard $crmCard): string
    {
        return \EmailCompiler::compileText($this, $crmCard);
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

    public function sendEmail(CrmCard $crmCard, ?string $emailAddress = null, ?Carbon $startSendingAt = null)
    {
        $this->emailQueues()
            ->create([
                'crm_card_id' => $crmCard->id,
                'start_sending_at' => $startSendingAt,
                'from_name' => $this->sender_name,
                'from_email' => $this->sender_email,
                'to_email' => $emailAddress, // TODO: emailadres uit email-crmcard halen
                'reply_to' => $this->reply_to,
                'subject' => $this->subject,
                'html_content' => $this->getCompiledHtml($crmCard, true, false),
                'text_content' => $this->getCompiledText($crmCard),
            ]);
    }
}
