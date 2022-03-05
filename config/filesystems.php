<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [
        'atrazoPagos' => [
            'driver' => 'local',
            'root' => storage_path('app/public/atrazoPagos'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'img_plantels' => [
            'driver' => 'local',
            'root' => storage_path('app/public/imagenes/plantels'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'img_especialidads' => [
            'driver' => 'local',
            'root' => storage_path('app/public/especialidads'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'plantillas_correos' => [
            'driver' => 'local',
            'root' => storage_path('app/public/imagenes/plantillas_correos'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'plantillas_correos_empresas' => [
            'driver' => 'local',
            'root' => storage_path('app/public/imagenes/plantillas_correos_empresas'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'cotizaciones' => [
            'driver' => 'local',
            'root' => storage_path('pdf/cotizaciones'),
            'url' => env('APP_URL').'/storage/pdf/cotizaciones',
            'visibility' => 'public',
        ],
        'conciliaciones' => [
            'driver' => 'local',
            'root' => storage_path('conciliaciones'),
            'url' => env('APP_URL').'/storage/conciliaciones',
            'visibility' => 'public',
        ],
        'files_facturacion' => [
            'driver' => 'local',
            'root' => storage_path('files_facturacion'),
            'url' => env('APP_URL').'/storage/files_facturacion',
            'visibility' => 'public',
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        
        'tmp_correos' => [
            'driver' => 'local',
            'root' => storage_path('app/tmp_correos'),
        ],

        'telegram_tickets' => [
            'driver' => 'local',
            'root' => storage_path('app/public/telegram_tickets'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

    ],

];
