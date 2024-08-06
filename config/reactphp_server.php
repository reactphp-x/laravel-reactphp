<?php
return [
    'server' => [
        'route_file' => '',
        'public_path' => base_path('public'),
        'options' => [
            'pid_file' => env('REACTPHP_PID_FILE', base_path('storage/logs/reactphp_server.pid')),
            'log_file' => env('REACTPHP_LOG_FILE', base_path('storage/logs/reactphp_server.log')),
            'daemonize' => env('REACTPHP_HTTP_DAEMONIZE', false),
        ],
    ],
    'middlewares' => [
        // Add your middleware here
    ],

];