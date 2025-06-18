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

namespace Tests\Unit\Jobs;

use App\DTO\Documents\DocumentData;
use App\Jobs\SavePagesAsImage;
use App\Models\DocumentModels\Document;
use App\Services\ServiceContracts\ImageServiceContract;
use Event;
use Google\Protobuf\Timestamp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Keepsake;
use Keepsake\Lib\Protocols\CommonResponseMeta;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;
use Keepsake\Lib\Protocols\PdfConverter\FilePointers;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Queue;
use Storage;
use Tests\TestCase;

#[CoversClass(SavePagesAsImage::class)]
class SavePagesAsImageTest extends TestCase
{
    use RefreshDatabase;

    private File $fakeCloudFile;

    private ConvertPdfToJpegResponse $convertPdfToJpegResponse;

    private DocumentData $docData;

    #[Test]
    public function arePagesSavedAsImages(): void
    {

        $this->markTestSkipped('come back to me later, file storage in testing is a biyotch');
        Queue::fake();
        // i have a feeling that move doesn't work the way you'd think with fake storage, even though a file is created on disk

        Event::fake();
        $this->convertPdfToJpegResponse = new ConvertPdfToJpegResponse();
        $this->fakeCloudFile = UploadedFile::fake()->create('test.pdf');
        Storage::fake(Keepsake::getTestDiskName())->put($this->fakeCloudFile->getRealPath(), file_get_contents($this->fakeCloudFile->getRealPath()));
        $filePointers = new FilePointers();
        $filePointers->setFileName($this->fakeCloudFile->getFileName())
            ->setFileFinalLocation($this->fakeCloudFile->getRealPath())
            ->setFileMime($this->fakeCloudFile->getMimeType())
            ->setPageNum(2)
            ->setPageFileSize($this->fakeCloudFile->getSize());
        $responseMeta = new CommonResponseMeta();
        $responseMeta->setCorrelationId('document-' . $this->docData->uploadedBy->id)
            ->setServiceId(1)
            ->setTimestamp(new Timestamp())
            ->setMessage('all good');
        $this->convertPdfToJpegResponse->setFiles([$filePointers])
            ->setMeta($responseMeta);

        $saveJob = new SavePagesAsImage($this->convertPdfToJpegResponse);

        $saveJob->handle(app()->make(ImageServiceContract::class));

    }

    public function setUp(): void
    {

        parent::setUp();
        $factoryDoc = Document::factory()->create();
        $this->docData = DocumentData::fromModel($factoryDoc);
        $this->actingAs($factoryDoc->uploadedBy);

    }
}
