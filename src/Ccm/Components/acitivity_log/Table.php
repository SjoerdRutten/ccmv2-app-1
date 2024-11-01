<?php

namespace Sellvation\CCMV2\Ccm\Components\acitivity_log;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Spatie\Activitylog\Models\Activity;

class Table extends Component
{
    public function __construct(public Model $performedOn) {}

    public function render(): View
    {
        return view('ccm::components.activity_log.table')
            ->with([
                'activities' => Activity::forSubject($this->performedOn)
                    ->latest()
                    ->get(),
            ]);
    }
}
