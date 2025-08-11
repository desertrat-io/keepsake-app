<?php

namespace App\Listeners\Processing;

use App\Events\Processing\PdfToJpegCompleted;
use App\Jobs\SavePagesAsImage;
use App\Models\EventModels\PdfToJpegCompletedEvent;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

#[CodeCoverageIgnore]
class PdfToJpegCompletedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(PdfToJpegCompleted $event): void
    {
        $eventModel = new PdfToJpegCompletedEvent();
        $eventModel->meta = $event->getPdfToJpegResponse()->getMeta()->serializeToJsonString();
        $eventModel->storage_id = $event->getPdfToJpegResponse()->getStorageId();
        $eventModel->processing_finished_at = $event->getPdfToJpegResponse()->getMeta()->getTimestamp()->getSeconds();
        $eventModel->save();
        SavePagesAsImage::dispatch($event->getPdfToJpegResponse())->onQueue('save_pages_as_image');
    }
}
