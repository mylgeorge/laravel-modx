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

    'connection' => env('MODX_CONNECTION','mysql')
];