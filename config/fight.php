<?php

declare(strict_types=1);

return [
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
];
