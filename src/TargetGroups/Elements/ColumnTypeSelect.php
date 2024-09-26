<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeSelect extends ColumnType
{
    public function __construct(public array $options = [])
    {
        $this->name = 'select';
        $this->label = 'Select';
    }
}
