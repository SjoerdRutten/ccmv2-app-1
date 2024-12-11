<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeFloat extends ColumnType
{
    public function __construct()
    {
        $this->name = 'float';
        $this->label = 'Float';
    }
}
