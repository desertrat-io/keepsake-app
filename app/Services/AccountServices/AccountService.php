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

namespace App\Services\AccountServices;

use App\DTO\Accounts\AccountData;
use App\DTO\Accounts\UserData;
use App\Repositories\RepositoryContracts\AccountRepositoryContract as AccountRepository;
use App\Repositories\RepositoryContracts\UserRepositoryContract as UserRepository;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\AccountServiceContract;

readonly class AccountService implements AccountServiceContract, KeepsakeService
{
    public function __construct(
        private AccountRepository $accountRepository,
        private UserRepository $userRepository
    ) {
    }

    /**
     * creates a user based on a validated form request
     * @param UserData $userData
     * @return UserData
     */
    public function createUser(UserData $userData, string $password): UserData
    {
        $userData = $this->userRepository->createNewUser($userData, $password, true);
        $this->createAccount($userData);
        return $userData;
    }

    public function createAccount(UserData $userData): AccountData
    {
        return $this->accountRepository->createNewAccountFromUser($userData);
    }
}
