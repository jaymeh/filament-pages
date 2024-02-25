<?php

// config for Jaymeh/FilamentPages
return [
    /*
    |--------------------------------------------------------------------------
    | Pages Model
    |--------------------------------------------------------------------------
    |
    | This is the model which will be used when interacting with pages.
    |
    */

    'pages_model' => \Modules\Pages\app\Models\Page::class,

    /*
    |--------------------------------------------------------------------------
    | Traffic Cop
    |--------------------------------------------------------------------------
    |
    | Indicates whether Nova should check for modifications between viewing
    | and updating a resource.
    |
    */

    'traffic_cop' => true,
];
