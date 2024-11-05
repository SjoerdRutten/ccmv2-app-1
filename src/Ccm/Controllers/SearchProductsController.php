<?php

namespace Sellvation\CCMV2\Ccm\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\Orders\Models\Product;

class SearchProductsController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->input('q');

        $query = Product::search($q)
            ->options(['query_by' => '*'])
            ->get()
            ->sortBy('name')
            ->toArray();

        return response()->json(array_values($query));
    }

    public function selected(Request $request)
    {
        $ids = $request->input('ids');
        $ids = explode(',', $ids);

        $query = Product::whereIn('id', $ids)
            ->orderBy('name')
            ->get();

        return response()->json($query);
    }
}
