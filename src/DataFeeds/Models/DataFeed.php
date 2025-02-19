<?php

namespace Sellvation\CCMV2\DataFeeds\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class DataFeed extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'is_active',
        'is_public',
        'name',
        'description',
        'type',
        'feed_config',
        'data_config',

    ];

    protected $casts = [
        'feed_config' => 'json',
        'data_config' => 'json',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function dataFeedFetched(): HasMany
    {
        return $this->hasMany(DataFeedFetch::class);
    }
}
