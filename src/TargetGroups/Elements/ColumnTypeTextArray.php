<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeTextArray extends ColumnType
{
    public function __construct()
    {
        $this->name = 'text_array';
        $this->label = 'Text array';
    }
}
