<?php

namespace App\Listeners\Images;

use App\Events\Images\ImageUploaded;
use App\Models\EventModels\ImageUploadedEvent;

/**
 * @codeCoverageIgnore
 */
class ImageUploadedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ImageUploaded $event): void
    {
        $model = new ImageUploadedEvent();
        $model->uploader = $event->imageData->uploadedBy->email;
        $model->uploaded_id = $event->imageData->uploadedBy->id;
        $model->meta = $event->imageMetaData->toArray();
        $model->save();
    }
}
