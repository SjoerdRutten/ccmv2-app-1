<?php

declare(strict_types=1);

use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

if (! function_exists('actionProfile')) {
    function actionProfile(int $targetGroupId, ?string $crmId = null): bool
    {
        $crmId = $crmId ?? \Context::get('crmId', null);

        if ($crmId === null) {
            return false;
        }

        $targetGroup = TargetGroup::find($targetGroupId);

        return \TargetGroupSelector::count($targetGroup->filters, $crmId) > 0;
    }
}
