<?php

namespace Sellvation\CCMV2\Forms\Facades;

use Spatie\StructureDiscoverer\Discover;

class FormAction
{
    private array $formActions = [];

    public function registerFormAction(\Sellvation\CCMV2\Forms\Actions\FormAction $formAction)
    {
        $this->formActions[] = $formAction;
        $this->formActions = \Arr::sort($this->formActions, fn ($row) => $row->name);
    }

    public function discover()
    {
        foreach (Discover::in(__DIR__.'/../Actions')
            ->classes()
            ->extending(\Sellvation\CCMV2\Forms\Actions\FormAction::class)
            ->get() as $action) {
            $x = new $action;

            $this->registerFormAction($x);
        }
    }

    public function getFormActions()
    {
        $this->discover();

        return $this->formActions;
    }

    public function getUserFormActions()
    {
        $actions = $this->getFormActions();

        return \Arr::where($actions, fn ($action) => ! $action->alwaysExecute);
    }

    public function getAlwaysExecuteFormActions()
    {
        $actions = $this->getFormActions();

        return \Arr::where($actions, fn ($action) => $action->alwaysExecute);
    }
}
