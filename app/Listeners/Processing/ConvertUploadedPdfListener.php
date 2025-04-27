<?php

namespace App\Listeners\Processing;

use App\Events\Images\PdfUploaded;
use App\Jobs\ConvertPdfToJpeg;

/**
 * @codeCoverageIgnore
 */
class ConvertUploadedPdfListener
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
        ConvertPdfToJpeg::dispatch($event->document)->onQueue('pdf_converter');
    }
}
