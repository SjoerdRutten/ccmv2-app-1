<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeInteger extends ColumnType
{
    public function __construct()
    {
        $this->name = 'integer';
        $this->label = 'Integer';
    }
}
