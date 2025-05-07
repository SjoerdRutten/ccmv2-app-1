<?php

namespace Sellvation\CCMV2\Ccm\Http\Controllers;

use App\Http\Controllers\Controller;

class ServerStatusController extends Controller
{
    public function __invoke()
    {
        $serverInfo = \Larinfo::getServerInfo();

        $data = [];
        $data['cpu_count'] = \Arr::get($serverInfo, 'hardware.cpu_count');
        $data['load'] = sys_getloadavg();
        $data['disk'] = \Arr::get($serverInfo, 'hardware.disk');
        $data['ram'] = \Arr::get($serverInfo, 'hardware.ram');

        return response()->json($data);
    }
}
