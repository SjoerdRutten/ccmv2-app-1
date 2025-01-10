<?php

namespace Sellvation\CCMV2\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class CrmCardController extends Controller
{
    public function show(CrmCard $crmCard)
    {
        return response()->json($crmCard);
    }
}
