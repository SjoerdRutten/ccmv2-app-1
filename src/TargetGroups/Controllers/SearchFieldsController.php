<?php

namespace Sellvation\CCMV2\TargetGroups\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class SearchFieldsController extends Controller
{
    public function search(Request $request)
    {
        $query = CrmField::query()
            ->where('name', 'like', '%'.$request->input('q').'%')
            ->where('is_hidden', 0)
            ->orderBy('name')
            ->get()
            ->toArray();

        return response()->json(array_values($query));
    }

    public function selected(Request $request)
    {
        $ids = $request->input('ids');
        $ids = explode(',', $ids);

        $query = CrmField::query()
            ->whereIn('id', $ids)
            ->orderBy('name')
            ->get();

        return response()->json($query);
    }
}
