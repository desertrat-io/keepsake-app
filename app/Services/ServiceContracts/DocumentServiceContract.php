<?php

namespace App\Services\ServiceContracts;

use App\DTO\Documents\DocumentData;
use App\DTO\Images\ImageData;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

interface DocumentServiceContract
{

    public function createDocument(
        UploadedFile $uploadedFile,
        ?string      $customTitle = null,
        ?ImageData   $imageData = null,
    ): DocumentData;

    /**
     * @param string $documentUUID
     * @return array<Data>
     */
    public function getDocumentThumbnails(string $documentUUID): array;

    public function getPathToPhysicalDocument(string $documentUUID): string;
}
