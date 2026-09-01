<?php

declare(strict_types=1);

return [
    'broadcast' => [
        'event_name' => env('FIGHT_BROADCAST_EVENT', 'fight.private'),
    ],
    'templates_path' => resource_path('views'),
    'security' => [
        // Development-only defaults keep the profile bootable; production keys are environment-owned.
        'hmac' => [
            'public' => env('FIGHT_HMAC_PUBLIC', 'fight-laravel'),
            'private' => env('FIGHT_HMAC_PRIVATE', '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef'),
            'time_tolerance' => (int) env('FIGHT_HMAC_TIME_TOLERANCE', 300),
        ],
        'jwt' => [
            'secret' => env('FIGHT_JWT_SECRET', '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef'),
            'algorithm' => env('FIGHT_JWT_ALGORITHM', 'HS256'),
        ],
    ],
    'scheduler' => [
        'timezone' => env('FIGHT_SCHEDULER_TIMEZONE', 'UTC'),
        'from_email' => env('FIGHT_SCHEDULER_FROM_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
    ],
];
