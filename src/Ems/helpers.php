<?php

declare(strict_types=1);

if (! function_exists('emailContent')) {
    function emailContent(int $emailContentId, array $parameters = []): mixed
    {
        $emailContent = \Sellvation\CCMV2\Ems\Models\EmailContent::find($emailContentId);
        if ($emailContent) {
            return \EmailCompiler::render(html: $emailContent->content, crmCard: \Context::get('crmCard'), email: \Context::get('email'), data: $parameters);
        } else {
            return null;
        }
    }
}
