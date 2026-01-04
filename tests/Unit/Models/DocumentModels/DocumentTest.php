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

namespace Tests\Unit\Models\DocumentModels;

use App\Models\AccountModels\User;
use App\Models\DocumentModels\Document;
use App\Models\ImageModels\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(Document::class)]
class DocumentTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function doesModelSave(): void
    {
        $document = Document::factory()->create([
            'image_id' => Image::factory()->create()->id
        ]);
        $this->assertDatabaseHas('documents', ['id' => $document->id]);
    }

    #[Test]
    public function doesDocumentHaveUploader(): void
    {
        User::truncate();
        $user = User::factory()->create();
        $document = Document::factory()->create(['uploaded_by' => $user->id, 'image_id' => Image::factory()->create()->id]);
        $this->assertEquals($user->id, $document->uploaded_by);
        $this->assertInstanceOf(User::class, $document->uploadedBy);
    }

    #[Test]
    public function doesDocumentHavePages(): void
    {
        $rootImage = Image::factory()->create();
        $document = Document::factory()->create([
            'image_id' => $rootImage->id
        ]);
        Image::factory()->count(3)->create([
            'parent_image_id' => $rootImage->id
        ]);

        $this->assertCount(3, $document->pages);
        $this->assertInstanceOf(Image::class, $document->pages->first());
        $this->assertEquals($rootImage->id, $document->pages->first()->parent_image_id);

    }

    #[Test]
    public function doesDocumentRelateToARootImage(): void
    {
        $image = Image::factory()->create();
        $document = Document::factory()->create([
            'image_id' => $image->id
        ]);

        $this->assertInstanceOf(Image::class, $document->image);
        $this->assertEquals($image->id, $document->image->id);
    }
}
