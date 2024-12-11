<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

class ColumnTypeSelectInteger extends ColumnType
{
    public function __construct(public array $options = [])
    {
        $this->name = 'select_integer';
        $this->label = 'Select integer';
    }
}
