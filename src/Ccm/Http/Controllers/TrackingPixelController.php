<?php

namespace Sellvation\CCMV2\Ccm\Http\Controllers;

use App\Http\Controllers\Controller;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;

class TrackingPixelController extends Controller
{
    public function __invoke($onlineVersion, Email $email, CrmCard $crmCard)
    {
        if ($crmCard) {
            $lastOpen = $email->trackablePixelOpens()
                ->where('crm_card_id', $crmCard->id)
                ->where('online_version', $onlineVersion)
                ->latest()
                ->first();

            if (! $lastOpen || $lastOpen->created_at->diffInSeconds(now()) > 30) {
                $email->trackablePixelOpens()->create([
                    'crm_card_id' => $crmCard->id,
                    'online_version' => $onlineVersion,
                ]);
            }
        }

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        // Create an image, 1x1 pixel in size
        $im = imagecreate(1, 1);
        $white = imagecolorallocate($im, 255, 255, 255);
        imagesetpixel($im, 1, 1, $white);

        header('content-type:image/jpg');
        imagejpeg($im);
    }
}
