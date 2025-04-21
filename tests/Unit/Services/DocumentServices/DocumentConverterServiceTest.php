<?php
/*
 * Copyright (c) 2025
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify, merge,
 *  publish, distribute, sublicense, and/or sell copies of the Software, and to permit
 *  persons to whom the Software is furnished to do so, subject to the following
 *  conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPIRES
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NON INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
declare(strict_types=1);

namespace Tests\Unit\Services\DocumentServices;

use App\DTO\Documents\DocumentData;
use App\Models\DocumentModels\Document;
use App\Services\DocumentServices\DocumentConverterService;
use Event;
use Google\Protobuf\Timestamp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Keepsake\Lib\Protocols\CommonResponseMeta;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;
use Keepsake\Lib\Protocols\PdfConverter\FilePointers;
use Keepsake\Lib\Protocols\PdfConverter\KeepsakePdfConverterClient;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DocumentConverterService::class)]
class DocumentConverterServiceTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function convertsViaGrpcService(): void
    {
        $fakeFile = TemporaryUploadedFile::fake()->image('fake.jpeg');
        $docData = DocumentData::fromModel(Document::factory()->create());
        $response = new ConvertPdfToJpegResponse();
        $filePointers = new FilePointers();
        $filePointers->setFileName($fakeFile->getFileName())
            ->setFileFinalLocation($fakeFile->getRealPath())
            ->setFileMime($fakeFile->getMimeType())
            ->setPageNum(2)
            ->setPageFileSize($fakeFile->getSize());
        $responseMeta = new CommonResponseMeta();
        $responseMeta->setCorrelationId($docData->uuid)
            ->setServiceId(1)
            ->setTimestamp(new Timestamp())
            ->setMessage('all good');
        $response->setFiles([$filePointers])
            ->setMeta($responseMeta);
        $grpcClientMock = $this->mock(KeepsakePdfConverterClient::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('ConvertToPdf')->once()->andReturnSelf();

            $mock->shouldReceive('wait')->once()->andReturn([$response, 1]);
        });
        $docConverterService = $this->app->makeWith(DocumentConverterService::class, ['keepsakePdfConverterClient' => $grpcClientMock]);
        Event::fake();
        $results = $docConverterService->convertViaGrpcService($docData);

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertCount(1, $results);
        $this->assertInstanceOf(FilePointers::class, $results->first());
        $filePointerResult = $results->first();
        $this->assertEquals($filePointerResult->getFileName(), $filePointers->getFileName());

    }
}
