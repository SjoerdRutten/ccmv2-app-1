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
            if (\Str::endsWith($field['crm_field_id'], '_optin')) {
                $crmField = CrmField::find(\Str::substr($field['crm_field_id'], 0, -6));
                $fields[$key]['name'] = '_'.$crmField->name.'_optin';
                $fields[$key]['is_optin'] = true;
            } else {
                $crmField = CrmField::find($field['crm_field_id']);
                $fields[$key]['name'] = $crmField->name;
            }
            $fields[$key]['crmField'] = $crmField;

            // Correct and validate values
            $data[$fields[$key]['name']] = $crmField->correctAndValidate($request->input($fields[$key]['name']));
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
