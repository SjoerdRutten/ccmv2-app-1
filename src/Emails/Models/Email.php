<?php

namespace Sellvation\CCMV2\Emails\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Email extends Model
{
    use HasEnvironment;

    protected $fillable = [
    ];

    protected function casts()
    {
        return [
        ];
    }

    public function emails(): BelongsTo
    {
        return $this->belongsTo(EmailCategory::class);
    }
}
