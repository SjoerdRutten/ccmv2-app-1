<?php

namespace Sellvation\CCMV2\TargetGroups\Controllers;

use App\Http\Controllers\Controller;

class TargetGroupOverviewController extends Controller
{
    public function __invoke()
    {
        return view('target-group-selector.filter-overview');
    }
}
