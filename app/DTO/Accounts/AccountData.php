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

namespace App\DTO\Accounts;

use App\DTO\DefaultIds;
use App\DTO\DefaultTimestamps;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Override;
use Ramsey\Uuid\Uuid;

class AccountData implements JsonSerializable, Arrayable
{
    use DefaultTimestamps;
    use DefaultIds;

    public readonly ?int $userId;
    public readonly ?bool $isLocked;
    public readonly ?bool $isMfaEnabled;
    public readonly ?bool $isDeleted;
    public readonly ?UserData $user;

    /**
     * @param int|null $id
     * @param Uuid|null $uuid
     * @param int|null $userId
     * @param bool|null $isLocked
     * @param bool|null $isMfaEnabled
     * @param Carbon|null $createdAt
     * @param Carbon|null $updatedAt
     * @param Carbon|null $deletedAt
     * @param bool|null $isDeleted
     * @param UserData|null $user
     */
    public function __construct(
        ?int $id = null,
        ?Uuid $uuid = null,
        ?int $userId = null,
        ?bool $isLocked = null,
        ?bool $isMfaEnabled = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null,
        ?Carbon $deletedAt = null,
        ?bool $isDeleted = false,
        ?UserData $user = null
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->userId = $userId;
        $this->isLocked = $isLocked;
        $this->isMfaEnabled = $isMfaEnabled;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->isDeleted = $isDeleted;
        $this->user = $user;
    }

    #[Override] public function toArray()
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->userId,
            'user' => $this->user,
            'is_locked' => $this->isLocked,
            'is_mfa_enabled' => $this->isMfaEnabled,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'deleted_at' => $this->deletedAt,
            'is_deleted' => $this->isDeleted
        ];
    }

    #[Override] public function jsonSerialize(): mixed
    {
        return json_encode([
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->userId,
            'user' => $this->user,
            'is_locked' => $this->isLocked,
            'is_mfa_enabled' => $this->isMfaEnabled,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'deleted_at' => $this->deletedAt,
            'is_deleted' => $this->isDeleted
        ]);
    }


}
