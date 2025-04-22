<?php

namespace Sellvation\CCMV2\TargetGroups\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\CrmCards\Models\Builders\CrmFieldType;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class SearchFieldsController extends Controller
{
    public function search(Request $request)
    {
        $fieldTypes = CrmFieldType::query()
            ->pluck('name', 'id');

        $fields = CrmField::query()
            ->select([
                'id',
                'crm_field_type_id',
                'name',
                'label',
            ])
            ->where('name', 'like', '%'.$request->input('q').'%')
            ->where('is_hidden', 0)
            ->orderBy('name')
            ->get();

        $data = [];
        foreach ($fields as $field) {
            $field = $field->toArray();
            $field['type'] = $fieldTypes[$field['crm_field_type_id']];

            switch ($field['type']) {
                case 'EMAIL':
                    $postFixes = [
                        '_valid',
                        '_possible',
                        '_abuse',
                        '_abuse_timestamp',
                        '_bounce_reason',
                        '_bounce_score',
                        '_bounce_type',
                        '_type',
                    ];

                    $data[] = $field;
                    $name = $field['name'];
                    foreach ($postFixes as $postFix) {
                        $field['name'] = '_'.$name.$postFix;
                        $data[] = $field;
                    }
                    break;
                case 'MEDIA':
                    $postFixes = [
                        '_allowed',
                        '_optin',
                        '_optin_timestamp',
                        '_confirmed_optin',
                        '_confirmed_optin_timestamp',
                        '_optout',
                        '_optout_timestamp',
                    ];

                    $name = $field['name'];
                    foreach ($postFixes as $postFix) {
                        $field['name'] = '_'.$name.$postFix;
                        $data[] = $field;
                    }
                    break;
                default:
                    $data[] = $field;
            }
        }

        return response()->json($data);
    }

    public function selected(Request $request)
    {
        $data = [];

        if ($request->has('fields')) {
            $fields = $request->input('fields');

            foreach ($fields as $name => $id) {
                $crmField = CrmField::query()
                    ->select([
                        'id',
                        'crm_field_type_id',
                        'name',
                        'label',
                    ])
                    ->findOrFail($id);

                $row = $crmField->toArray();
                $row['name'] = $name;

                $data[] = $row;
            }
        }

        return response()->json($data);
    }
}
