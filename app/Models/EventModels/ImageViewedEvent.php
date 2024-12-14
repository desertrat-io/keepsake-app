<?php

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

class ImageViewedEvent extends Model
{

    protected $connection = 'mongodb';

    protected $collection = 'image_viewed_events';
}
