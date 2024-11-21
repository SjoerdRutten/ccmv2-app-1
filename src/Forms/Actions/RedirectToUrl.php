<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RedirectToUrl extends RedirectAction
{
    public string $name = 'Redirect naar URL';

    public function handle(): RedirectResponse|Redirector
    {
        $data = $this->form->success_redirect_params ?? [];

        return redirect(\Arr::get($data, 'url'));
    }

    public function form(array $data): View
    {
        return view('forms::actions.redirect-to-url')->with($data);
    }
}
