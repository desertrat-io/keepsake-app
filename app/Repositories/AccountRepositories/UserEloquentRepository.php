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

namespace App\Repositories\AccountRepositories;

use App\DTO\Accounts\UserData;
use App\Models\AccountModels\User;
use App\Repositories\KeepsakeRepository;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use Hash;

class UserEloquentRepository implements KeepsakeRepository, UserRepositoryContract
{
    public function concreteEntityClass(): string
    {
        return User::class;
    }

    public function createNewUser(UserData $userData, string $password, bool $returnAsData = false): User|UserData
    {
        $user = User::create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => Hash::make($password)
        ]);

        if ($returnAsData) {
            return $this->generateUserAsData($user);
        }
        return $user;
    }

    private function generateUserAsData(User $user, $includeAccount = false): UserData
    {
        if ($includeAccount) {
            return UserData::from($user->load('account'));
        }
        return UserData::from($user);
    }

    public function getUserById(int $userId, bool $includeAccount = false, bool $asData = false): User|UserData
    {
        $user = User::find($userId);
        if ($includeAccount) {
            $user->load('account');
        }
        if ($asData) {
            return $this->generateUserAsData($user, $includeAccount);
        }
        return $user;
    }
}
