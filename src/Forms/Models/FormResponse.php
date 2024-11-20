<?php

namespace Sellvation\CCMV2\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Forms\Events\FormResponseCreatedEvent;

class FormResponse extends Model
{
    protected $fillable = [
        'form_id',
        'crm_card_id',
        'ip_address',
        'headers',
        'data',
    ];

    protected $casts = [
        'headers' => 'json',
        'data' => 'json',
    ];

    protected $dispatchesEvents = [
        'created' => FormResponseCreatedEvent::class,
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }
}
