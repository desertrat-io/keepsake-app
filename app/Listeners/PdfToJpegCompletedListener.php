<?php

namespace App\Listeners;

use App\Events\PdfToJpegCompleted;
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
