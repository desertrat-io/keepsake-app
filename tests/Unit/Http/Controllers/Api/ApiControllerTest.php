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

namespace Tests\Unit\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Lib\Enum\HttpCode;
use App\Lib\Enum\ResponseCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ApiController::class)]
class ApiControllerTest extends TestCase
{
    #[Test]
    public function returnsValidSuccessResponseForSuccessConditions(): void
    {
        // i generated this with AI to see how it performed. made a few tweaks

        // Arrange: Create an anonymous implementation to access protected method
        $controller = new class () extends ApiController {
            public function testResponse(
                string       $message,
                Collection   $payload,
                HttpCode     $http,
                ResponseCode $resp
            ): JsonResponse {
                return $this->apiResponse($message, $payload, $http, $resp);
            }
        };

        $message = 'Success';
        $payload = collect(['key' => 'value']);
        $httpCode = HttpCode::OK;
        $responseCode = ResponseCode::API_SUCCESS;

        $response = $controller->testResponse($message, $payload, $httpCode, $responseCode);
        $data = $response->getData(true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($message, $data['message']);
        $this->assertEquals(['key' => 'value'], $data['data']);
        $this->assertEquals($responseCode->value, $data['response_code']);
    }
}
