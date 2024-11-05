<?php

namespace Sellvation\CCMV2\TargetGroups\Elements;

use Livewire\Wireable;

abstract class ColumnType implements Wireable
{
    public string $name;

    public string $label;

    public bool $active = true;

    public function toLivewire()
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'active' => $this->active,
        ];
    }

    public static function fromLivewire($value)
    {
        return new static($value['name'], $value['label'], $value['active']);
    }
}
