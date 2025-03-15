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

namespace Tests\Unit\Models\AccountModels;

use App\Models\AccountModels\Account;
use App\Models\AccountModels\User;
use App\Models\DocumentModels\Document;
use App\Models\ImageModels\Image;
use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(User::class)]
class UserTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function doUserModelsSave(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    #[Test]
    public function doUserModelsHaveRelations(): void
    {
        User::truncate();
        $user = User::factory()->create();
        $image = Image::factory()->create(['uploaded_by' => $user]);
        $this->assertDatabaseHas('users', ['email' => $user->email]);
        $this->assertEquals($user->id, $image->uploaded_by);
        Image::factory()->count(3)->create(['uploaded_by' => $user]);
        $this->assertCount(4, $user->images);

        $account = Account::factory()->create(['user_id' => $user->id]);
        $this->assertEquals($account->id, $user->account->id);
        $documents = Document::factory()->count(2)->create(['uploaded_by' => $user->id]);
        $this->assertEquals(2, $user->documents->count());
    }

    #[Test]
    public function passwordsShouldNotLeak(): void
    {
        User::factory()->create();
        $user = User::first();
        $this->assertModelExists($user);
        $this->assertFalse(Arr::has($user->jsonSerialize(), 'password'));
    }
}
