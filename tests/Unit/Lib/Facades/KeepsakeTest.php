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

namespace Tests\Unit\Lib\Facades;

use App\Events\Errors\KeepsakeExceptionThrown;
use App\Exceptions\KeepsakeExceptions\KeepsakeStorageException;
use App\Lib\Facades\Impl\Keepsake as KeepsakeImpl;
use Event;
use Keepsake;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Tests\TestCase;

#[CoversClass(KeepsakeImpl::class)]
class KeepsakeTest extends TestCase
{
    #[Test]
    public function doesIdFromKeyWork(): void
    {
        // TODO: make this less stupid
        $this->assertInstanceOf(UuidInterface::class, Keepsake::idFromKey('keepsake-key-' . Uuid::uuid4()));
    }

    #[Test]
    public function doesIdToKeyWork(): void
    {
        $keepsakeId = Keepsake::idFromKey('keepsake-key-' . Uuid::uuid4());
        $this->assertStringStartsWith('keepsake-key', Keepsake::idToKey($keepsakeId));
        $this->assertStringStartsWith('keepsake-key', Keepsake::idToKey($keepsakeId->toString()));
    }

    #[Test]
    public function exceptionsThrowTheExceptionLoggerEvent(): void
    {
        Event::fake();
        Keepsake::logException(new KeepsakeStorageException(fake()->sentence()));
        Event::assertDispatched(KeepsakeExceptionThrown::class);
    }

    #[Test]
    public function generatesCorrectStoragePath(): void
    {
        $generatedPath = Keepsake::getNewStoragePath();
        $this->assertStringStartsWith('media/images/' . config(
                'keepsake.tenant_name',
                env('DEFAULT_TENANT_NAME')
            ) . '/', $generatedPath);
    }

    #[Test]
    public function generatesCorrectDiskNameForTesting(): void
    {
        $this->assertEquals(config('keepsake.test_disk_name'), Keepsake::getCurrentDiskName());
    }

}
