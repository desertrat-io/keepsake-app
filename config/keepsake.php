<?php

/*
 * Copyright (c) 2022
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

use Grpc\ChannelCredentials;

return [
    'pdf_converter_url' => env('KEEPSAKE_PDF_CONVERTER', '127.0.0.1:50051'),
    'pdf_converter_credentials' => ChannelCredentials::createInsecure(),
    'cloud_provider' => env('CLOUD_PROVIDER', 'AWS'),
    //'tenant_name' => env('TENANT_NAME')
    // in kb
    'min_image_size' => 128,
    'model_mode' => env('MODEL_MODE', 'eloquent'),
    'local_disk_name' => env('KEEPSAKE_LOCAL_DISK_NAME', 'keepsake_local'),
    'test_disk_name' => env('KEEPSAKE_TEST_DISK_NAME', 'keepsake_test'),
];
