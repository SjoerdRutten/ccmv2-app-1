<?php

namespace Sellvation\CCMV2\Ccm\Traits;

use Sellvation\CCMV2\Forms\Actions\FormAction;
use Spatie\StructureDiscoverer\Discover;

trait HasFormActions
{
    public function registerFormActions()
    {
        $reflector = new \ReflectionClass($this);
        $dir = dirname($reflector->getFileName());

        foreach (Discover::in($dir.'/Actions')
            ->classes()
            ->extending(FormAction::class)
            ->get() as $action) {
            \FormAction::registerFormAction(new $action);
        }
    }
}
