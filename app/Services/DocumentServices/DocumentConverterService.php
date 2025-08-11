<?php

namespace App\Services\DocumentServices;

use App\DTO\Documents\DocumentData;
use App\Events\Processing\PdfToJpegCompleted;
use App\Exceptions\KeepsakeExceptions\KeepsakePdfException;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\DocumentConverterServiceContract;
use Arr;
use Exception;
use Illuminate\Support\Facades\Log;
use Keepsake;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegRequest;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;
use Keepsake\Lib\Protocols\PdfConverter\KeepsakePdfConverterClient;
use Keepsake\Lib\Protocols\S3DataStore;

readonly class DocumentConverterService implements DocumentConverterServiceContract, KeepsakeService
{
    public function __construct(
        private KeepsakePdfConverterClient $keepsakePdfConverterClient,
        private ConvertPdfToJpegRequest    $request = new ConvertPdfToJpegRequest(),
        private S3DataStore                $s3DataStore = new S3DataStore()
    )
    {
    }

    /**
     * @param DocumentData $documentData
     * @return ConvertPdfToJpegResponse
     */
    public function convertViaGrpcService(DocumentData $documentData): ConvertPdfToJpegResponse
    {
        $storagePath = $documentData->storageId;
        $storageBasePathSegs = explode(separator: '/', string: $documentData->storageId);
        $fileName = Arr::last($storageBasePathSegs);
        array_pop($storageBasePathSegs);
        $storageBasePath = Arr::join($storageBasePathSegs, '/');
        Log::info('Sending for conversion: ' . $storagePath);
        $this->request
            ->setCorrelationId('document-' . $documentData->id)
            ->setFileLocator($storagePath)
            ->setFileName($fileName)
            ->setUserUuid($documentData->uploadedBy->uuid)
            ->setImageUuid($documentData->image->uuid)
            ->setImageId($documentData->image->id)
            ->setStorageId($documentData->storageId)
            ->setOriginalMime('application/pdf');
        $this->s3DataStore
            ->setRegion(env('AWS_DEFAULT_REGION', 'eu-north-1'))
            ->setBucketName(env('AWS_BUCKET'))
            ->setTenantName(env('DEFAULT_TENANT_NAME'))
            ->setFileKey($storagePath)
            ->setFilePath($storageBasePath)
            ->setFileName($fileName);
        $this->request->setS3DataStore($this->s3DataStore);
        try {
            [$result, $status] = $this->keepsakePdfConverterClient->ConvertToPdf(argument: $this->request)->wait();
            Log::info('request made');
            if ($result instanceof ConvertPdfToJpegResponse) {
                Log::info('Response received!');
                event(new PdfToJpegCompleted($result));
                return $result;
            }
        } catch (Exception $exception) {
            Keepsake::logException(new KeepsakePdfException($exception->getMessage()));
            var_dump($exception->getMessage());
        }

        return new ConvertPdfToJpegResponse();
    }
}
