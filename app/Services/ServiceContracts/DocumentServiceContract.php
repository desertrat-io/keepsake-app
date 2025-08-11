<?php

namespace App\Services\ServiceContracts;

use App\DTO\Documents\DocumentData;
use App\DTO\Images\ImageData;
use Illuminate\Http\UploadedFile;

interface DocumentServiceContract
{

    public function createDocument(
        UploadedFile $uploadedFile,
        ?string      $customTitle = null,
        ?ImageData   $imageData = null,
    ): DocumentData;
}
