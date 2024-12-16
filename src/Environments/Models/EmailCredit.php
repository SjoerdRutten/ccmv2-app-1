<?php

namespace Sellvation\CCMV2\Environments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailCredit extends Model
{
    protected $fillable = [
        'quantity',
    ];

    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class);
    }
}
