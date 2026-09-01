<?php

declare(strict_types=1);

return [
    'file-storage' => [
        'disk' => env('FIGHT_FILE_STORAGE_DISK', env('FILESYSTEM_DISK', 'local')),
    ],
];
