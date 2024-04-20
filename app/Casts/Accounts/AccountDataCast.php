<?php

namespace App\Casts\Accounts;

use App\DTO\Accounts\AccountData;
use App\Models\AccountModels\Account;
use App\Models\AccountModels\User;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AccountDataCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     * @param Model<Account> $model
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($model instanceof User) {
            // TODO: find a better way to do this. Maybe the model relationships need to be re-thought?
            $account = $model->account()->first();
            return new AccountData(
                id: $account->id,
                uuid: $account->uuid,
                userId: $account->user_id,
                isLocked: $account->is_locked,
                isMfaEnabled: $account->mfa_enabled,
                createdAt: $account->created_at,
                updatedAt: $account->updated_at,
                deletedAt: $account->deleted_at,
                isDeleted: $account->is_deleted,
            );
        }

        return new AccountData(
            id: $attributes['id'],
            uuid: $attributes['uuid'],
            userId: $attributes['user_id'],
            isLocked: $attributes['is_locked'],
            isMfaEnabled: $attributes['is_mfa_enabled'],
            createdAt: $attributes['created_at'],
            updatedAt: $attributes['updated_at'],
            deletedAt: $attributes['deleted_at'],
            isDeleted: $attributes['is_deleted'],
            user: $attributes['user']
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @param Model<Account> $model
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value instanceof AccountData) {
            throw new InvalidArgumentException('Value is not an instance of AccountData');
        }
        return [
            'user_id' => $value->userId,
            'user' => $value->user,
            'is_locked' => $value->isLocked,
            'mfa_enabled' => $value->isMfaEnabled,
            'deleted_at' => $value->deletedAt,
            'updated_at' => $value->updatedAt
        ];
    }
}
