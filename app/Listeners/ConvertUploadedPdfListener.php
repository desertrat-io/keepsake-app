<?php

namespace App\Listeners;

use App\Events\PdfUploaded;

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
        //
    }
}
