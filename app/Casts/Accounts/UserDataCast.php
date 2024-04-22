<?php

namespace App\Casts\Accounts;

use App\DTO\Accounts\UserData;
use App\Models\AccountModels\User;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class UserDataCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     * @param Model<User> $model
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): UserData
    {
        dd($attributes);
        return new UserData(
            id: $attributes['id'],
            uuid: $attributes['uuid'],
            account: $model->account,
            name: $attributes['name'],
            email: $attributes['email'],
            emailVerifiedAt: $attributes['email_verified_at'],
            createdAt: $attributes['created_at'],
            updatedAt: $attributes['updated_at'],
            deletedAt: $attributes['deleted_at'],
            isDeleted: $model->is_deleted,
            rememberToken: $attributes['remember_token'],
            images: $attributes['images']
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @param Model<User> $model
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof UserData) {
            throw new InvalidArgumentException('The given value is not a UserData object');
        }

        return [
            'name' => $value->name,
            'email' => $value->email,
            'email_verified_at' => $value->emailVerifiedAt,
            'remember_token' => $value->rememberToken,
            'deleted_at' => $value->deletedAt,
            'updated_at' => $value->updatedAt
        ];
    }
}
