<?php

return [

    
    'fetch' => PDO::FETCH_OBJ,
    'default' => env('DB_CONNECTION', ''),
    'connections' => [

        'mysql' => [

            'driver' => 'mysql',
            'host' => env('DB_HOST_MYSQL', ''),
            'port' => env('DB_PORT_MYSQL', ''),
            'database' => env('DB_DATABASE_MYSQL', ''),
            'username' => env('DB_USERNAME_MYSQL', ''),
            'password' => env('DB_PASSWORD_MYSQL', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            
        ],

        // 'oracle' => [

        //     'driver'       => 'oracle',
        //     'host'         => env('DB_HOST_ORA', ''),
        //     'port'         => env('DB_PORT_ORA', ''),
        //     'database' => env('DB_DATABASE_ORA', ''),
        //     'username' => env('DB_USERNAME_ORA', ''),
        //     'password' => env('DB_PASSWORD_ORA', ''),
        //     'service_name' => env('DB_SERVICE_NAME_ORA', ''),
        //     'charset'      => 'AL32UTF8',
        //     'prefix'       => '',
           
        // ]

    ],

    'migrations' => 'migrations',

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
