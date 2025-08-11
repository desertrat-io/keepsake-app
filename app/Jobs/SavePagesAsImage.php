<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\ServiceContracts\ImageServiceContract;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\UploadedFile;
use Keepsake;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;
use Keepsake\Lib\Protocols\PdfConverter\FilePointers;
use Log;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;
use Storage;
use Str;

#[CodeCoverageIgnore]
class SavePagesAsImage implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected ConvertPdfToJpegResponse $convertPdfToJpegResponse)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(ImageServiceContract $imageService): void
    {
        collect($this->convertPdfToJpegResponse->getFiles())
            ->each(function (FilePointers $file) use ($imageService) {
                $localFileStream = Storage::disk(Keepsake::getCurrentDiskName())
                    ->get($file->getFileFinalLocation());

                Storage::disk(Keepsake::getLocalDiskName())->put($file->getFileFinalLocation(), $localFileStream);
                $finalPath = Storage::disk(Keepsake::getLocalDiskName())->path($file->getFileFinalLocation());
                $uploadedFile = new UploadedFile(path: $finalPath, originalName: $file->getFileName());
                Log::info($file->serializeToString());
                $imageData = $imageService->saveImage(
                    uploadedFile: $uploadedFile,
                    customTitle: $file->getFileName(),
                    customPath: Str::beforeLast($file->getFileFinalLocation(), '/'),
                    customUploader: $this->convertPdfToJpegResponse->getMeta()->getUserUuid(),
                    documentId: (int)Str::replaceFirst('document-', '', $this->convertPdfToJpegResponse->getMeta()->getCorrelationId()),
                    parentImageId: $file->getParentImageId(),
                );
            });
        $imageService->imageProcessed(storageId: $this->convertPdfToJpegResponse->getStorageId());
    }
}
