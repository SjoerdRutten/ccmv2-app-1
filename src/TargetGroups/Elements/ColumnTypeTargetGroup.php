<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeTargetGroup extends ColumnType
{
    public function __construct()
    {
        $this->name = 'target_group';
        $this->label = 'Target Group';
    }
}
