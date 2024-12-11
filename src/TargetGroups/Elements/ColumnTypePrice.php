<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypePrice extends ColumnType
{
    public function __construct()
    {
        $this->name = 'price';
        $this->label = 'Price';
    }
}
