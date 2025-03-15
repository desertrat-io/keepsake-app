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
use App\Repositories\DocumentRepositories\DocumentEloquentRepository;
use App\Services\DocumentServices\DocumentConverterService;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DocumentConverterService::class)]
class DocumentConverterServiceTest extends TestCase
{

    #[Test]
    public function convertsViaGrpcService(): void
    {
        // there really isn't much to test yet
        // also this needs to be updated once the class is more fleshed out
        $documentRepoMock = $this->partialMock(DocumentEloquentRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('concreteEntityClass')->once()->andReturn(DocumentEloquentRepository::class);
        });
        $docConverterService = $this->app->makeWith(DocumentConverterService::class, ['documentRepository' => $documentRepoMock]);
        $docData = DocumentData::fromModel(Document::factory()->create());
        $results = $docConverterService->convertViaGrpcService($docData);
        $this->assertInstanceOf(Collection::class, $results);
    }
}
