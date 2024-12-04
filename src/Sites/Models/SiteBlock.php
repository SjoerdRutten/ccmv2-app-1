<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Forms\Models\Form;

class SiteBlock extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_category_id',
        'form_id',
        'name',
        'description',
        'start_at',
        'end_at',
        'body',
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
