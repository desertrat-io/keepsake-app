<?php

namespace App\Listeners\Processing;

use App\Events\Images\PdfUploaded;
use App\Models\EventModels\PdfUploadedEvent as PdfUploadedEventModel;

/**
 * @codeCoverageIgnore
 */
class PdfUploadedListener
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
    public function handle(PdfUploaded $event): void
    {
        $model = new PdfUploadedEventModel();
        $model->uploader = $event->document->uploadedBy;
        $model->uploaded_id = $event->document->uploadedBy->id;
        $model->document_name = $event->document->title;
        $model->save();
    }
}
