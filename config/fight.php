<?php

declare(strict_types=1);

return [
    'broadcast' => [
        'event_name' => env('FIGHT_BROADCAST_EVENT', 'fight.private'),
    ],
    'file-storage' => [
        'disk' => env('FIGHT_FILE_STORAGE_DISK', env('FILESYSTEM_DISK', 'local')),
    ],
    'templates_path' => resource_path('views'),
    'scheduler' => [
        'timezone' => env('FIGHT_SCHEDULER_TIMEZONE', 'UTC'),
        'from_email' => env('FIGHT_SCHEDULER_FROM_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
    ],
];
