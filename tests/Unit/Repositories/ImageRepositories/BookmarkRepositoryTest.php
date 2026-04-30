<?php

/*
 * Copyright (c) 2026
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

namespace Tests\Unit\Repositories\ImageRepositories;

use App\DTO\Images\BookmarkData;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Bookmark;
use App\Repositories\ImageRepositories\BookmarkEloquentRepository;
use App\Repositories\RepositoryContracts\BookmarkRepositoryContract;
use Mockery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(BookmarkEloquentRepository::class)]
class BookmarkRepositoryTest extends TestCase
{
    /** @var BookmarkRepositoryContract */
    private BookmarkRepositoryContract $bookmarkRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock of the interface
        $this->bookmarkRepository = $this->app->make(BookmarkRepositoryContract::class);
    }

    #[Test]
    public function isModelBound(): void
    {
        if (config('keepsake.model_mode') === 'eloquent') {
            $repo = new BookmarkEloquentRepository();
            $this->assertEquals(Bookmark::class, $repo->concreteEntityClass());
        } else {
            $this->markTestSkipped('Model mode is not eloquent, no need for this test');
        }
    }

    // TODO: update when actual data is returned
    #[Test]
    public function upsertBookmarkReturnsEmpty(): void
    {
        $bookmark = Bookmark::factory()->create(['created_by' => User::factory()->create()->id]);
        $bookmarkData = $this->bookmarkRepository->upsertBookmark(BookmarkData::fromModel($bookmark));
        $this->assertInstanceOf(BookmarkData::class, $bookmarkData);
        $this->assertEquals($bookmarkData->id, $bookmark->id);

    }

    // TODO: also needs updating when actual data is returned
    #[Test]
    public function bookmarksReturnedBasedOnImage(): void
    {
        $bookmarks = $this->bookmarkRepository->getBookmarksForImage(1);
        $this->assertInstanceOf(BookmarkData::class, $bookmarks);
        $this->assertEquals(null, $bookmarks->id);
    }

    #[Test]
    public function baseModelMatchesRepository(): void
    {
        $baseModelClass = $this->bookmarkRepository->concreteEntityClass();
        $this->assertEquals(Bookmark::class, $baseModelClass);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
