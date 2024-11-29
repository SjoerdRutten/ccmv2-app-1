<?php

namespace Sellvation\CCMV2\Sites\Http\Controllers;

use Illuminate\Support\Facades\Response;

class FaviconController extends FrontendController
{
    public function __invoke()
    {

        if ($this->site->favicon) {

            $mimeType = \Storage::disk($this->site->favicon_disk)
                ->mimeType($this->site->favicon);

            $icon = \Storage::disk($this->site->favicon_disk)
                ->get($this->site->favicon);

            $response = Response::make($icon, 200);
            $response->header('Content-Type', $mimeType);

            return $response;
        }
        abort(404);
    }
}
