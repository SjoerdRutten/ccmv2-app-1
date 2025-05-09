<?php

namespace Sellvation\CCMV2\Forms\Facades;

class FormAction
{
    private array $formActions = [];

    public function registerFormAction(\Sellvation\CCMV2\Forms\Actions\FormAction $formAction)
    {
        $this->formActions[] = $formAction;
        $this->formActions = \Arr::sort($this->formActions, fn ($row) => $row->name);
    }

    public function getFormActions()
    {
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
