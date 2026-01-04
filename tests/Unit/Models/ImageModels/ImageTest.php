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

namespace Tests\Unit\Models\ImageModels;

use App\Models\AccountModels\User;
use App\Models\DocumentModels\Document;
use App\Models\ImageModels\Bookmark;
use App\Models\ImageModels\Image;
use App\Models\ImageModels\ImageMeta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(Image::class)]
class ImageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function doesModelSave(): void
    {
        $image = Image::factory()->create();
        $this->assertDatabaseHas('images', ['id' => $image->id]);
    }

    #[Test]
    public function canBeAPage(): void
    {
        $seedImage = Image::factory()->create(); // seed with a single image
        $image = Image::factory()->create(['parent_image_id' => $seedImage->id]);
        $document = Document::factory()->create(['image_id' => $image->parent_image_id]);
        $this->assertInstanceOf(Document::class, $image->pageOf);
        $this->assertEquals($document->id, $image->pageOf->id);
    }

    #[Test]
    public function canGetMeta(): void
    {
        $image = Image::factory()->create();
        $imageMeta = ImageMeta::factory()->create(['image_id' => $image->id]);
        $this->assertInstanceOf(ImageMeta::class, $image->meta);
        $this->assertEquals($imageMeta->id, $image->meta->id);
    }

    #[Test]
    public function canGetUploader(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(['uploaded_by' => $user->id]);
        $this->assertInstanceOf(User::class, $image->uploadedBy);
        $this->assertEquals($user->id, $image->uploadedBy->id);
    }

    #[Test]
    public function canModelHaveAParent(): void
    {
        $parent = Image::factory()->create();
        $image = Image::factory()->create(['parent_image_id' => $parent->id]);
        $this->assertInstanceOf(Image::class, $image->parent);
        $this->assertEquals($parent->id, $image->parent->id);
    }

    #[Test]
    public function canHaveABookmark(): void
    {
        $image = Image::factory()->create();
        $bookmark = Bookmark::factory()->create(['image_id' => $image->id]);
        $this->assertInstanceOf(Bookmark::class, $image->bookmark);
        $this->assertEquals($bookmark->id, $image->bookmark->id);
    }
}
