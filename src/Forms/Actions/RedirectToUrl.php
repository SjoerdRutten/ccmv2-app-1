<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Sellvation\CCMV2\Forms\Models\Form;
use Sellvation\CCMV2\Forms\Models\FormResponse;

class RedirectToUrl extends RedirectAction
{
    public string $name = 'Redirect naar URL';

    public function handle(Form $form, FormResponse $formResponse): RedirectResponse
    {
        $data = $form->success_redirect_params ?? [];

        return redirect(\Arr::get($data, 'url'));
    }

    public function form(array $data): View
    {
        return view('forms::actions.redirect-to-url')->with($data);
    }
}
