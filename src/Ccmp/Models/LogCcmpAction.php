<?php

namespace Sellvation\CCMV2\Ccmp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class LogCcmpAction extends Model
{
    use Prunable;

    protected $fillable = [
        'action_id',
        'crm_id',
        'status',
        'response',
    ];

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subMonth());
    }
}
