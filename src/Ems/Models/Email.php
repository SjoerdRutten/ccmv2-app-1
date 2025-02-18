<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Blade;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Email extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'id',
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
        'updated_at',
        'created_at',
    ];

    protected function casts()
    {
        return [
            'is_locked' => 'bool',
            'is_template' => 'bool',
        ];
    }

    public function emailCategory(): BelongsTo
    {
        return $this->belongsTo(EmailCategory::class);
    }

    private function getStripoHtml($data)
    {
        $html = Blade::render(
            $this->stripo_html,
            $data,
        );

        return \Stripo::compileTemplate($html, $this->stripo_css);
    }

    public function getCompiledHtml(CrmCard $crmCard)
    {
        \Context::add('crmCard', $crmCard);

        // Fill data for template
        $data = [];
        $data['email'] = $this;
        $data['crmCard'] = $crmCard;
        $data['crmCardData'] = $crmCard->data;

        $data = \BladeExtensions::mergeData($data, 'EMS');

        if ($this->html_type === 'STRIPO') {
            return $this->getStripoHtml($data);
        } else {
            return Blade::render(
                $this->html,
                $data,
            );

        }
    }
}
