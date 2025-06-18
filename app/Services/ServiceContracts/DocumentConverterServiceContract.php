<?php

namespace App\Services\ServiceContracts;

use App\DTO\Documents\DocumentData;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;

interface DocumentConverterServiceContract
{

    /**
     * @param DocumentData $documentData
     * @return ConvertPdfToJpegResponse
     */
    public function convertViaGrpcService(DocumentData $documentData): ConvertPdfToJpegResponse;
}
