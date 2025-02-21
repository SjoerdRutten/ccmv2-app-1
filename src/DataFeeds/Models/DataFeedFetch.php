<?php

namespace Sellvation\CCMV2\DataFeeds\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataFeedFetch extends Model
{
    protected $fillable = [
        'data_feed_id',
        'status',
        'started_at',
        'ended_at',
        'disk',
        'file_name',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function dataFeed(): BelongsTo
    {
        return $this->belongsTo(DataFeed::class);
    }
}
