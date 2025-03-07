<?php

namespace Sellvation\CCMV2\Ccm\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Junges\TrackableJobs\Models\TrackedJob;

trait HasTrackedJobs
{
    public function trackedJobs(): MorphMany
    {
        return $this->morphMany(TrackedJob::class, 'trackable');
    }
}
