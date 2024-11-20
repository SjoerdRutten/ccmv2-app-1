<?php

namespace Sellvation\CCMV2\Forms\Facades;

use Spatie\StructureDiscoverer\Discover;

class RedirectAction
{
    private array $redirectActions = [];

    public function registerRedirectAction(\Sellvation\CCMV2\Forms\Actions\RedirectAction $redirectAction)
    {
        $this->redirectActions[] = $redirectAction;
        $this->redirectActions = \Arr::sort($this->redirectActions, fn ($row) => $row->name);
    }

    public function discover()
    {
        foreach (Discover::in(__DIR__.'/../Actions')
            ->classes()
            ->extending(\Sellvation\CCMV2\Forms\Actions\RedirectAction::class)
            ->get() as $action) {
            $x = new $action;

            $this->registerRedirectAction($x);
        }
    }

    public function getRedirectActions()
    {
        $this->discover();

        return $this->redirectActions;
    }
}
