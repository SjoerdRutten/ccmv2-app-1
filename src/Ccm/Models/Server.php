<?php

namespace Sellvation\CCMV2\Ccm\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Server extends Model
{
    protected $fillable = [
        'name',
        'type',
        'ip',
        'status_url',
        'config',
    ];

    protected $casts = [
        'config' => 'json',
    ];

    public function statusses(): HasMany
    {
        return $this->hasMany(ServerStatus::class, 'server_id', 'id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(ServerStatus::class, 'server_id', 'id')->latest();
    }

    protected function cpuPercentage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->status ? round(($this->status->load / $this->status->cpu_count) * 100) : 0
        );
    }

    protected function diskFreePercentage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->status ? 100 - round(($this->status->disk_free_space / $this->status->disk_total_space) * 100) : 0
        );
    }

    protected function ramFreePercentage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->status ? 100 - round(($this->status->ram_free_space / $this->status->ram_total_space) * 100) : 0
        );
    }
}
