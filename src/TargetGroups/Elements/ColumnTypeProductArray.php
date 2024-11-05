<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeProductArray extends ColumnType
{
    public function __construct()
    {
        $this->name = 'product_array';
        $this->label = 'Product array';
    }
}
