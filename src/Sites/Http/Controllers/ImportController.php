<?php

namespace Sellvation\CCMV2\Sites\Http\Controllers;

use Sellvation\CCMV2\Sites\Models\SiteImport;

class ImportController extends FrontendController
{
    public function __invoke(SiteImport $siteImport, string $name)
    {
        if ($siteImport->js) {
            $mimeType = 'application/javascript';
        } elseif ($siteImport->css) {
            $mimeType = 'text/css';
        }

        return response($siteImport->body, 200, ['Content-Type' => $mimeType]);
    }
}
