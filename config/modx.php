<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Modx Instalation Path
    |--------------------------------------------------------------------------
    |
    | The path modx is installed
    | 
    */

    'path' => env('MODX_PATH',base_path() . '/modx'),

    /*
    |--------------------------------------------------------------------------
    | Database Connection
    |--------------------------------------------------------------------------
    |
    | A Connection defined in config/database.php
    */

    'connection' => env('MODX_CONNECTION','mysql'),


   /*
    |--------------------------------------------------------------------------
    | Boot Modx Sevice On Request
    |--------------------------------------------------------------------------
    |
    | Boot modx cms and inject in views as $modx
    | set to false if you only need modx user managment
    |
    */

    'boot' => env('MODX_BOOT', true)
];