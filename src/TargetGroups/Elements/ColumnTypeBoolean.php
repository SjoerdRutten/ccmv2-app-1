<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeBoolean extends ColumnType
{
    public function __construct()
    {
        $this->name = 'boolean';
        $this->label = 'Boolean';
    }
}
