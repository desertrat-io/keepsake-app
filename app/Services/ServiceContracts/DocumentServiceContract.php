<?php

namespace App\Services\ServiceContracts;

use App\DTO\Documents\DocumentData;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

interface DocumentServiceContract
{
    public function convertPdf(string $storageId): DocumentData;

    public function createDocument(
        TemporaryUploadedFile $temporaryUploadedFile,
        ?string $customTitle = null
    ): DocumentData;
}
