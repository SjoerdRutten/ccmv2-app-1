<?php

namespace Sellvation\CCMV2\Orders\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Product extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'environment_id',
        'brand_id',
        'sku',
        'ean',
        'name',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
