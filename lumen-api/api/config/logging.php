<?php

use App\Logging\CustomLogger;
use App\Logging\LogFormat;

return [
    'default'   => env('LOG_CHANNEL', 'custom'),

    'channels'  => [
        'custom'        => [
            'driver'    => 'custom',
            'via'       => CustomLogger::class,
            'tap'       => [LogFormat::class]
        ]
    ]
];
