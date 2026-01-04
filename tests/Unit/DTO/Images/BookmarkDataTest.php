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

namespace Tests\Unit\DTO\Images;

use App\DTO\Images\BookmarkData;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Bookmark;
use App\Models\ImageModels\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(BookmarkData::class)]
class BookmarkDataTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function fromModelWorks(): void
    {
        $label = fake()->word();
        $user = User::factory()->create();
        $image = Image::factory()->create();
        $bookmark = Bookmark::factory()->create([
            'bookmark_label' => $label,
            'image_id' => $image->id,
            'created_by' => $user->id,
        ]);

        $bookmarkData = BookmarkData::fromModel($bookmark);

        // Assert
        $this->assertEquals($bookmark->id, $bookmarkData->id);
        $this->assertEquals($bookmark->uuid, $bookmarkData->uuid);
        $this->assertEquals($label, $bookmarkData->bookmarkLabel);
        $this->assertEquals($image->id, $bookmarkData->image->id);
        $this->assertEquals($user->id, $bookmarkData->createdBy->id);

        $this->assertEquals($bookmark->created_at->toDateTimeString(), $bookmarkData->createdAt->toDateTimeString());
    }

    #[Test]
    public function doesNullWorkNicely(): void
    {

        $bookmarkData = BookmarkData::fromModel(null);

        $this->assertNull($bookmarkData->id);
        $this->assertNull($bookmarkData->bookmarkLabel);
        $this->assertNull($bookmarkData->uuid);
    }
}
