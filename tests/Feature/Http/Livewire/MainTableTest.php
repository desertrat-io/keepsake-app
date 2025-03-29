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

namespace Tests\Feature\Http\Livewire;

use App\Http\Livewire\MainTable;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Models\ImageModels\ImageMeta;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Storage;
use Tests\TestCase;

#[CoversClass(MainTable::class)]
class MainTableTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected EloquentCollection $images;
    protected Collection $imageMetaEntities;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->images = Image::factory()->count(3)->create(['uploaded_by' => $this->user->id]);
        $this->imageMetaEntities = collect([]);
        $this->images->each(fn(Image $image) => $this->imageMetaEntities->push(ImageMeta::factory()->create(['image_id' => $image->id])));


    }

    #[Test]
    public function doesTableDisplay(): void
    {
        Storage::fake('s3');
        $this->withoutVite();
        $this->actingAs($this->user)->get(route('private.home'))->assertOk()->assertViewIs('private.index');
        $this->imageMetaEntities
            ->each(fn(ImageMeta $imageMetaData) => Livewire::test(MainTable::class)->assertOk()->assertSee($imageMetaData->current_image_name));


    }
}
