<?php

namespace App\Services\ServiceContracts;

use App\DTO\Documents\DocumentData;
use Illuminate\Http\UploadedFile;

interface DocumentServiceContract
{
    public function convertPdf(string $storageId): DocumentData;

    public function createDocument(
        UploadedFile $temporaryUploadedFile,
        ?string      $customTitle = null
    ): DocumentData;
}
