<?php

namespace Sellvation\CCMV2\Forms\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
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
            $data[$fields[$key]['name']] = $crmField->correctAndValidate($request->input($fields[$key]['name']));

            if (in_array($fields[$key]['name'], $request->input('optin'))) {
                $data['_'.$fields[$key]['name'].'_optin'] = 1;
                $data['_'.$fields[$key]['name'].'_optin_timestamp'] = now()->toDateTimeString();
                $data['_'.$fields[$key]['name'].'_optout'] = null;
                $data['_'.$fields[$key]['name'].'_optout_timestamp'] = now();
            }
        }

        // After creating the response, the data will be processed in a seperate process
        $form->formResponses()->create([
            'ip_address' => $request->ip(),
            'headers' => $request->headers->all(),
            'data' => $data,
        ]);

        dd('Hier moet een redirect komen naar een pagina....');
    }
}
