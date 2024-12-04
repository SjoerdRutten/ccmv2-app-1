<?php

namespace Sellvation\CCMV2\Forms\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Forms\Actions\RedirectAction;
use Sellvation\CCMV2\Forms\Models\Form;
use Sellvation\CCMV2\Forms\Models\FormResponse;

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
        $formResponse = new FormResponse([
            'ip_address' => $request->ip(),
            'headers' => $request->headers->all(),
            'data' => $data,
            'form_id' => $form->id,
        ]);
        $formResponse = $this->attachCrmCard($formResponse);

        if ($form->success_redirect_action) {
            /** @var RedirectAction $action */
            $action = new ($form->success_redirect_action)($form, $formResponse);

            return $action->handle();
        } else {
            abort(200, 'Geen redirect action ingesteld');
        }
    }

    private function attachCrmCard($formResponse)
    {
        if (! $formResponse->crmCard) {
            $form = $formResponse->form;
            $crmCard = null;

            foreach ($form->fields as $field) {
                if (\Arr::get($field, 'attach_to_crm_card')) {
                    $crmField = CrmField::find($field['crm_field_id']);

                    if ($crmField->is_shown_on_target_group_builder) {
                        try {
                            $crmCard = CrmCard::search('*')
                                ->options([
                                    'page' => 1,
                                    'per_page' => 1,
                                    'filter_by' => $crmField['name'].':='.$formResponse->data[$crmField->name],
                                ])
                                ->first();
                        } catch (\Exception $e) {
                        }
                    } else {
                        // Slow, but necessary if data nog available in index
                        $crmCard = CrmCard::query()
                            ->where(\DB::raw('data->"$.'.$crmField->name.'"'), '=', $formResponse->data[$crmField->name])
                            ->first();
                    }
                }
            }

            // If no crmCard has been created, create a CRM Card
            if (! $crmCard) {
                $crmCard = new CrmCard;
                $crmCard->setData($formResponse->data);
                $crmCard->environment_id = $formResponse->form->environment_id;
                $crmCard->save();
            }

            $formResponse->crmCard()->associate($crmCard);
        }

        return $formResponse;
    }
}
