<?php

namespace Sellvation\CCMV2\Ccm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerStatus extends Model
{
    protected $table = 'server_status';

    protected $fillable = [
        'cpu_count',
        'disk_total_space',
        'disk_free_space',
        'ram_total_space',
        'ram_free_space',
        'load',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class, 'server_id', 'id');
    }
}
