<?php

namespace App\Listeners;

use App\Events\PdfUploaded;
use App\Models\EventModels\PdfUploadedEvent;

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
        $model = new PdfUploadedEvent();
        $model->uploader = $event->document->uploadedBy;
        $model->uploaded_id = $event->document->uploadedBy->id;
        $model->document_name = $event->document->title;
        $model->save();
    }
}
