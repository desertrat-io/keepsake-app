<?php

namespace App\Listeners;

use App\Events\PdfUploaded;
use App\Jobs\ConvertPdfToJpeg;
use App\Models\EventModels\PdfUploadedEvent as PdfUploadedEventModel;

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
        ConvertPdfToJpeg::dispatch($event->document);
    }
}
