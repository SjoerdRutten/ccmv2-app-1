<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

use Illuminate\Support\Str;
use Livewire\Wireable;

class Column implements Wireable
{
    public function __construct(public string $name, public ColumnType $columnType, public string $label = '')
    {
        $this->label = Str::replace('_', ' ', $label);
    }

    public function toLivewire()
    {
        return [
            'name' => $this->name,
            'columnType' => $this->columnType->name,
            'label' => $this->label ?: $this->name,
        ];
    }

    public static function fromLivewire($value)
    {
        return new static($value['name'], $value['label']);
    }
}
