<?php

declare(strict_types=1);

return function (string $apiKey): ?array {
    $apiKeys = [
        'an3i21uy39812ndasbdsa' => [
            'name' => 'Yofit Gym UI',
            'enabled' => true
        ]
    ];

    return $apiKeys[$apiKey] ?? null;
};
