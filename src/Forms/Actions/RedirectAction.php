<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Sellvation\CCMV2\Forms\Models\Form;
use Sellvation\CCMV2\Forms\Models\FormResponse;

abstract class RedirectAction
{
    abstract public function handle(Form $form, FormResponse $formResponse): RedirectResponse;

    abstract public function form(array $data): View;
}
