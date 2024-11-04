<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeIntegerArray extends ColumnType
{
    public function __construct()
    {
        $this->name = 'integer_array';
        $this->label = 'Integer array';
    }
}
