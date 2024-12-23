<?php

namespace Sellvation\CCMV2\MailServers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class SendRule extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'priority',
        'name',
        'rules',
    ];

    protected $casts = [
        'rules' => 'array',
    ];

    public function mailServers(): BelongsToMany
    {
        return $this->belongsToMany(MailServer::class)->withPivot(['priority']);
    }
}
