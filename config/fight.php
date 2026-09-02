<?php

declare(strict_types=1);

return [
    'broadcast' => [
        'event_name' => env('FIGHT_BROADCAST_EVENT', 'fight.private'),
    ],
    'templates_path' => resource_path('views'),
    'security' => [
        'hmac' => [
            'public' => env('FIGHT_HMAC_PUBLIC'),
            'private' => env('FIGHT_HMAC_PRIVATE'),
            'time_tolerance' => (int) env('FIGHT_HMAC_TIME_TOLERANCE', 300),
        ],
        'jwt' => [
            'secret' => env('FIGHT_JWT_SECRET'),
            'algorithm' => env('FIGHT_JWT_ALGORITHM', 'HS256'),
        ],
    ],
    'scheduler' => [
        'timezone' => env('FIGHT_SCHEDULER_TIMEZONE', 'UTC'),
        'from_email' => env('FIGHT_SCHEDULER_FROM_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
    ],
];
