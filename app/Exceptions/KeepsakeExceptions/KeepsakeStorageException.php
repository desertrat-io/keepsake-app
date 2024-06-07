<?php

namespace App\Exceptions\KeepsakeExceptions;

use App\Lib\Enum\ErrorResponseCode;
use App\Lib\Enum\HttpCode;
use App\Lib\Enum\ResponseCode;

class KeepsakeStorageException extends KeepsakeException
{
    public function httpCode(): HttpCode
    {
        return HttpCode::SERVER_ERROR;
    }

    public function errorResponseCode(): ErrorResponseCode
    {
        return ErrorResponseCode::IMAGE_STORAGE_ERROR;
    }

}
