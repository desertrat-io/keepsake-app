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
use App\DTO\Images\ImageData;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JsonSerializable;
use Override;
use Ramsey\Uuid\Uuid;

class UserData implements JsonSerializable, Arrayable
{
    use DefaultTimestamps;
    use DefaultIds;


    public readonly ?string $name;
    public readonly ?string $email;
    public readonly ?Carbon $emailVerifiedAt;
    public readonly ?string $rememberToken;
    public readonly ?bool $isDeleted;
    public readonly ?AccountData $account;

    /**
     * @var Collection<ImageData>|null
     */
    public readonly ?Collection $images;


    /**
     * @param int|null $id
     * @param string|null $uuid
     * @param AccountData|null $account
     * @param string|null $name
     * @param string|null $email
     * @param Carbon|null $emailVerifiedAt
     * @param Carbon|null $createdAt
     * @param Carbon|null $updatedAt
     * @param Carbon|null $deletedAt
     * @param bool|null $isDeleted
     * @param string|null $rememberToken
     * @param Collection|null $images
     */
    public function __construct(
        ?int $id = null,
        ?Uuid $uuid = null,
        ?AccountData $account = null,
        ?string $name = null,
        ?string $email = null,
        ?Carbon $emailVerifiedAt = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null,
        ?Carbon $deletedAt = null,
        ?bool $isDeleted = false,
        ?string $rememberToken = null,
        ?Collection $images = null
    ) {
        $this->name = $name;
        $this->account = $account;
        $this->images = $images;
        $this->email = $email;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->rememberToken = $rememberToken;
        $this->id = $id;
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->isDeleted = $isDeleted;
    }


    #[Override] public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
        return json_encode([
            'name' => $this->name,
            'account' => $this->account,
            'images' => $this->images,
            'email' => $this->email,
            'email_verified_at' => $this->emailVerifiedAt,
            'remember_token' => $this->rememberToken,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'deleted_at' => $this->deletedAt,
            'is_deleted' => $this->isDeleted
        ]);
    }

    #[Override] public function toArray()
    {
        return [
            'name' => $this->name,
            'account' => $this->account,
            'images' => $this->images,
            'email' => $this->email,
            'email_verified_at' => $this->emailVerifiedAt,
            'remember_token' => $this->rememberToken,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'deleted_at' => $this->deletedAt,
            'is_deleted' => $this->isDeleted
        ];
    }
}
