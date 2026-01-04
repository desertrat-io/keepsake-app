<?php

namespace App\Services\ServiceContracts;

use App\DTO\Documents\DocumentData;
use App\DTO\Images\ImageData;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

interface DocumentServiceContract
{

    public function createDocument(
        UploadedFile $uploadedFile,
        ?string      $customTitle = null,
        ?ImageData   $imageData = null,
    ): DocumentData;

    public function getDocumentThumbnails(string $documentUUID): DataCollection|Lazy;
}
