<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeDate extends ColumnType
{
    public function __construct()
    {
        $this->name = 'date';
        $this->label = 'Datum';
    }
}
