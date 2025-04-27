<?php

namespace App\Listeners\Processing;

use App\Events\Processing\PdfToJpegCompleted;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;

class PdfToJpegCompletedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly ImageRepositoryContract $imageRepository, private readonly ImageMetaRepositoryContract $imageMetaRepository)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(PdfToJpegCompleted $event): void
    {

    }
}
