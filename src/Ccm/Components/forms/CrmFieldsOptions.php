<?php

namespace Sellvation\CCMV2\Ccm\Components\forms;

use Illuminate\View\Component;

class CrmFieldsOptions extends Component
{
    public function render(): string
    {

        return <<<'blade'
            @foreach (Sellvation\CCMV2\CrmCards\Models\CrmField::orderBy('name')->get() AS $crmField)
                @foreach ($crmField->fields AS $_field)
                    <option value="{{ $_field['id'] }}" data-type="{{ $_field['type'] }}">
                        {{ $_field['label'] }} ({{ $_field['type'] }})
                    </option>
                @endforeach
            @endforeach
blade;
    }
}
