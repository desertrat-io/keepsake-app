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

use App\Models\AccountModels\Account;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class AccountData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly ?int $id,
        public readonly ?string $uuid,
        public readonly ?int $userId,
        public readonly ?bool $isLocked,
        public readonly ?bool $isMfaEnabled,
        public readonly ?Carbon $createdAt,
        public readonly ?Carbon $updatedAt,
        public readonly ?Carbon $deletedAt,
        public readonly ?bool $isDeleted,
        public readonly Lazy|UserData $user
    ) {
    }

    public static function fromModel(Account $account): self
    {
        return new self(
            id: $account->id,
            uuid: $account->uuid,
            userId: $account->user_id,
            isLocked: $account->is_locked,
            isMfaEnabled: $account->mfa_enabled,
            createdAt: $account->created_at,
            updatedAt: $account->updated_at,
            deletedAt: $account->deleted_at,
            isDeleted: $account->is_deleted,
            user: Lazy::create(fn () => $account->user)
        );
    }
}
