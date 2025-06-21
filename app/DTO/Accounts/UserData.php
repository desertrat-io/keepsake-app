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

use App\DTO\Documents\DocumentData;
use App\DTO\Images\ImageData;
use App\Models\AccountModels\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
final class UserData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly ?int                  $id,
        public readonly ?string               $uuid,
        public readonly ?string               $name,
        public readonly ?string               $email,
        public readonly ?Carbon               $emailVerifiedAt,
        public readonly ?string               $rememberToken,
        public readonly ?Carbon               $createdAt,
        public readonly ?Carbon               $updatedAt,
        public readonly ?Carbon               $deletedAt,
        public readonly ?bool                 $isDeleted,
        /** @var Collection<ImageData> */
        public readonly null|Collection|Lazy  $images,
        /** @var Collection<DocumentData> */
        public readonly null|Collection|Lazy  $documents,
        public readonly null|Lazy|AccountData $account
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            uuid: $user->uuid,
            name: $user->name,
            email: $user->email,
            emailVerifiedAt: $user->email_verified_at,
            rememberToken: $user->remember_token,
            createdAt: $user->created_at,
            updatedAt: $user->updated_at,
            deletedAt: $user->deleted_at,
            isDeleted: false,
            images: Lazy::create(fn () => ImageData::collect($user->images)),
            documents: Lazy::create(fn () => DocumentData::collect($user->documents)),
            account: Lazy::create(fn () => AccountData::fromModel($user->account)),
        );
    }
}
