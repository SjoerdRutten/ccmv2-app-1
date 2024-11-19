<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TargetGroup extends Model
{
    use HasEnvironment;
    use LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'filters',
    ];

    protected function casts()
    {
        return [
            'filters' => 'json',
        ];
    }

    public function targetGroupExports(): HasMany
    {
        return $this->hasMany(TargetGroupExport::class);
    }

    protected function numberOfResults(): Attribute
    {
        return Attribute::make(
            get: fn () => TargetGroupSelectorFacade::count($this->filters)
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
}
