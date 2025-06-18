<?php

namespace App\Jobs;

use App\DTO\Documents\DocumentData;
use App\Services\ServiceContracts\DocumentConverterServiceContract as DocumentConverterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

// nothing really to test, it just runs a method. it it runs or it doesn't
#[CodeCoverageIgnore]
class ConvertPdfToJpeg implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly DocumentData $documentData)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(DocumentConverterService $documentConverterService): void
    {
        $documentConverterService->convertViaGrpcService($this->documentData);
    }
}
