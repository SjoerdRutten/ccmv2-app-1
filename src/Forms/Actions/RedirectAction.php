<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Sellvation\CCMV2\Forms\Models\Form;
use Sellvation\CCMV2\Forms\Models\FormResponse;

abstract class RedirectAction
{
    /**
     * @var string
     *             The name of the action, how it will appear in the system
     */
    public string $name = '';

    public function __construct(protected readonly ?Form $form = null, protected readonly ?FormResponse $formResponse = null) {}

    /**
     * @return RedirectResponse
     *                          Execute the action and returns a RedirectResponse
     */
    abstract public function handle(): RedirectResponse|Redirector;

    /**
     * @return View|null
     *                   Return a view with the config form for the action, or null of no
     *                   params are necessary
     */
    abstract public function form(array $data): ?View;
}
