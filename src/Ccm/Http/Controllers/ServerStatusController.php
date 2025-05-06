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
        $data['disk'] = \Arr::get($serverInfo, 'hardware.disk');
        $data['disk']['free_percentage'] = (\Arr::get($serverInfo, 'hardware.disk.free') / \Arr::get($serverInfo, 'hardware.disk.total')) * 100;
        $data['disk']['usage_percentage'] = 100 - $data['disk']['free_percentage'];
        $data['ram'] = \Arr::get($serverInfo, 'hardware.ram');
        $data['uptime'] = \Arr::get($serverInfo, 'uptime');

        return response()->json($data);
    }
}
