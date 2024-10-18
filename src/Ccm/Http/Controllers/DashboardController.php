<?php

namespace Sellvation\CCMV2\Ccm\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('ccm::dashboard');
    }
}
