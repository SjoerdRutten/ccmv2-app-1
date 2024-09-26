<?php

namespace Sellvation\CCMV2\TargetGroups\Controllers;

use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use App\Http\Controllers\Controller;

class TargetGroupFormController extends Controller
{
    public function __invoke(?TargetGroup $targetGroup = null)
    {
        return view('target-group::filter-form')
            ->with([
                'targetGroup' => $targetGroup ?: new TargetGroup,
            ]);
    }
}
