<?php

namespace Sellvation\CCMV2\Ccm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TrackableLink extends Model
{
    protected $fillable = [
        'link',
        'text',
        'html',
    ];

    public function trackable(): MorphTo
    {
        return $this->morphTo();
    }

    public function trackableLinkClicks(): HasMany
    {
        return $this->hasMany(TrackableLinkClick::class);
    }
}
