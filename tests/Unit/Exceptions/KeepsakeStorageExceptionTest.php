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

namespace Tests\Unit\Exceptions;

use App\Exceptions\KeepsakeExceptions\KeepsakeStorageException;
use App\Lib\Enum\ErrorResponseCode;
use App\Lib\Enum\HttpCode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(KeepsakeStorageException::class)]
class KeepsakeStorageExceptionTest extends TestCase
{
    #[Test]
    public function testKeepsakeStorageException(): void
    {
        // really basic test to see if the exception is configured right
        $exception = new KeepsakeStorageException();
        $this->assertEquals(HttpCode::SERVER_ERROR, $exception->httpCode());
        $this->assertEquals(ErrorResponseCode::IMAGE_STORAGE_ERROR, $exception->errorResponseCode());
    }

}
