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

use App\DTO\Accounts\UserData;
use App\DTO\Documents\DocumentData;
use App\Events\PdfUploaded;
use App\Models\AccountModels\User;
use App\Repositories\RepositoryContracts\DocumentRepositoryContract;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use App\Services\DocumentServices\DocumentService;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Storage;
use Tests\TestCase;

#[CoversClass(DocumentService::class)]
class DocumentServiceTest extends TestCase
{
    use RefreshDatabase;

    private DocumentService $documentService;
    private $fakeDoc;

    #[Test]
    public function canConvertDocumentToPdf(): void
    {
        // TODO: finish up
        $docResult = $this->documentService->convertPdf('abc');
        $this->assertInstanceOf(DocumentData::class, $docResult);
    }

    #[Test]
    public function canSaveDocument(): void
    {
        Event::fake();
        Storage::fake('s3');
        $docData = $this->documentService->createDocument($this->fakeDoc);
        Event::assertDispatched(function (PdfUploaded $event) use ($docData) {
            return $event->document->id === $docData->id;
        });
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->fakeDoc = TemporaryUploadedFile::fake()->create('test.pdf');
        $user = User::factory()->create();
        $this->actingAs($user);
        $userRepoMock = $this->mock(UserRepositoryContract::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('getUserById')->andReturn(UserData::fromModel($user));
        });
        $docRepoMock = $this->mock(DocumentRepositoryContract::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('createDocument')->andReturn(DocumentData::from([]));
        });

        $this->documentService = $this->app->makeWith(
            DocumentService::class,
            ['userRepository' => $userRepoMock, 'documentRepository' => $docRepoMock]
        );
    }
}
