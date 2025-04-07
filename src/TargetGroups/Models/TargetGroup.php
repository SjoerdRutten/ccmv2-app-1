<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Ccm\Traits\HasCategory;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TargetGroup extends Model
{
    use HasCategory;
    use HasEnvironment;
    use LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'filters',
        'row_count',
        'row_count_updated_at',
    ];

    protected function casts()
    {
        return [
            'filters' => 'json',
            'row_count_updated_at' => 'datetime',
        ];
    }

    public function targetGroupExports(): HasMany
    {
        return $this->hasMany(TargetGroupExport::class);
    }

    protected function numberOfResults(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->row_count_updated_at ||
                    ($this->updated_at->timestamp !== $this->row_count_updated_at->timestamp) ||
                    ($this->row_count_updated_at->isBefore(now()->subMinutes(5)))
                ) {
                    $this->update([
                        'row_count' => TargetGroupSelectorFacade::count($this->filters),
                        'row_count_updated_at' => now(),
                    ]);
                }

                return $this->row_count;
            }
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
}
