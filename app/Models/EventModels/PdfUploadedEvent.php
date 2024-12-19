<?php

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

class PdfUploadedEvent extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'pdf_uploaded_events';
}
