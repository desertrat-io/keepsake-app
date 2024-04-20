<?php

/*
 * Copyright (c) 2023
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

namespace App\DTO\Images;

use App\DTO\Accounts\UserData;
use App\DTO\DefaultIds;
use App\DTO\DefaultTimestamps;
use Carbon\Carbon;

class ImageData
{
    use DefaultIds;
    use DefaultTimestamps;

    public readonly ?string $storageId;
    public readonly ?string $storagePath;
    public readonly ?UserData $uploadedBy;
    public readonly ?bool $isLocked;
    public readonly ?bool $isDirty;
    public readonly ?bool $isDeleted;

    /**
     * @param int|null $id
     * @param string|null $uuid
     * @param string|null $storageId
     * @param string|null $storagePath
     * @param UserData|null $uploadedBy
     * @param bool|null $isLocked
     * @param bool|null $isDirty
     * @param Carbon|null $createdAt
     * @param Carbon|null $updatedAt
     * @param Carbon|null $deletedAt
     * @param bool|null $isDeleted
     */
    public function __construct(
        ?int $id = null,
        ?string $uuid = null,
        ?string $storageId = null,
        ?string $storagePath = null,
        ?UserData $uploadedBy = null,
        ?bool $isLocked = false,
        ?bool $isDirty = false,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null,
        ?Carbon $deletedAt = null,
        ?bool $isDeleted = false
    ) {
        $this->storageId = $storageId;
        $this->storagePath = $storagePath;
        $this->uploadedBy = $uploadedBy;
        $this->isLocked = $isLocked;
        $this->isDirty = $isDirty;
        $this->id = $id;
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->isDeleted = $isDeleted;
    }


}
