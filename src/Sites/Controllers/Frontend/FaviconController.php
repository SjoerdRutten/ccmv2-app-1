<?php

namespace Sellvation\CCMV2\Sites\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Sellvation\CCMV2\Sites\Models\Site;

class FaviconController extends Controller
{
    public function __invoke(Site $site)
    {
        if ($site->favicon) {

            $mimeType = \Storage::disk($site->favicon_disk)
                ->mimeType($site->favicon);

            $icon = \Storage::disk($site->favicon_disk)
                ->get($site->favicon);

            $response = Response::make($icon, 200);
            $response->header('Content-Type', $mimeType);

            return $response;
        }
        abort(404);
    }
}
