<?php

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as IMagickDriver;

return [

    /*
    |--------------------------------------------------------------------------
    | ImageFacade Driver
    |--------------------------------------------------------------------------
    |
    | Intervention ImageFacade supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => [
        'gd' => GdDriver::class,
        'imagick' => IMagickDriver::class
    ]
];
