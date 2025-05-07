<?php

namespace Sellvation\CCMV2\Ccm\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\Ccm\Models\Server;

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

    public function set(Request $request, Server $server)
    {
        $data = $request->json()->all();

        $server->statusses()->create([
            'cpu_count' => \Arr::get($data, 'cpu_count', 0),
            'disk_total_space' => \Arr::get($data, 'disk.total'),
            'disk_free_space' => \Arr::get($data, 'disk.free'),
            'ram_total_space' => \Arr::get($data, 'ram.total'),
            'ram_free_space' => \Arr::get($data, 'ram.free'),
            'load' => \Arr::get($data, 'load.0'),
        ]);
    }
}
