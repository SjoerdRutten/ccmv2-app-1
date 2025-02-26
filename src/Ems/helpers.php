<?php

declare(strict_types=1);

if (! function_exists('emailContent')) {
    function emailContent(int $emailContentId): mixed
    {
        $emailContent = \Sellvation\CCMV2\Ems\Models\EmailContent::find($emailContentId);
        if ($emailContent) {
            return $emailContent->content;
        } else {
            return null;
        }
    }
}
