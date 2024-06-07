<?php

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

class KeepsakeExceptionEvent extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'keepsake_error_events';
}
