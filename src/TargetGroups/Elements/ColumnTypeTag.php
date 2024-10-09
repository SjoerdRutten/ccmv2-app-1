<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeTag extends ColumnType
{
    public function __construct()
    {
        $this->name = 'tag';
        $this->label = 'Kenmerk';
    }
}
