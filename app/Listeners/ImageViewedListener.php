<?php

namespace App\Listeners;

use App\Events\ImageViewed;
use App\Models\EventModels\ImageViewedEvent;

class ImageViewedListener
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
    public function handle(ImageViewed $event): void
    {
        $imageViewedEvent = new ImageViewedEvent();
        $imageViewedEvent->user_id = $event->userId;
        $imageViewedEvent->viewed_at = $event->eventTime;
        $imageViewedEvent->image_viewed = $event->imageId;
        $imageViewedEvent->save();
    }
}
