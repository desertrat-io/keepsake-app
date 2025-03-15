<?php

namespace App\Services\ServiceContracts;

use App\DTO\Documents\DocumentData;
use App\DTO\Images\ImageData;
use Illuminate\Support\Collection;

interface DocumentConverterServiceContract
{

    /**
     * @param DocumentData $documentData
     * @return Collection<ImageData>
     */
    public function convertViaGrpcService(DocumentData $documentData): Collection;
}
