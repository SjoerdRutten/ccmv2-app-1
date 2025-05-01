<?php

return [
    'environment' => env('CCM_ENVIRONMENT', 'production'),
    'environment_id' => env('CCM_ENVIRONMENT', null),
    'queues' => explode(',', env('CCM_QUEUES', 'default')),

    'sites' => [
        'favicon_disk' => env('CCM_SITES_FAVICON_DISK', 'local'),
        'favicon_path' => env('CCM_SITES_FAVICON_PATH', 'sites/favicon/'),
    ],

    'ssh_user' => env('SSH_USER', 'ccmv2'),
    'ssh_public_key' => env('SSH_PUBLIC_KEY', ''),
    'ssh_private_key' => env('SSH_PRIVATE_KEY', ''),
];
