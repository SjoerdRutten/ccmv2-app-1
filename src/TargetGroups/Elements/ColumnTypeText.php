<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeText extends ColumnType
{
    public function __construct()
    {
        $this->name = 'text';
        $this->label = 'Text';
    }
}
