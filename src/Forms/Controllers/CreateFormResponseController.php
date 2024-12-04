<?php

namespace Sellvation\CCMV2\Forms\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Forms\Actions\RedirectAction;
use Sellvation\CCMV2\Forms\Jobs\AttachCrmCardToFormResponseJob;
use Sellvation\CCMV2\Forms\Models\Form;

class CreateFormResponseController extends Controller
{
    public function __invoke(Request $request, Form $form)
    {
        $data = [];

        // First only get the fields which are attached to the form
        $fields = $form->fields;

        foreach ($fields as $key => $field) {
            $crmField = CrmField::find($field['crm_field_id']);
            $fields[$key]['name'] = $crmField->name;
            $fields[$key]['crmField'] = $crmField;

            // Correct and validate values
            $data[$fields[$key]['name']] = $crmField->correctAndValidate($request->input($fields[$key]['name']), \Arr::get($field, 'required', false));
        }

        $data['optin'] = $request->input('optin', []);

        // After creating the response, the data will be processed in a seperate process
        $formResponse = $form->formResponses()->create([
            'ip_address' => $request->ip(),
            'headers' => $request->headers->all(),
            'data' => $data,
        ]);

        AttachCrmCardToFormResponseJob::dispatchSync($formResponse);

        if ($form->success_redirect_action) {
            /** @var RedirectAction $action */
            $action = new ($form->success_redirect_action)($form, $formResponse);

            return $action->handle();
        } else {
            abort(200, 'Geen redirect action ingesteld');
        }
    }
}
