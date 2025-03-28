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

namespace Tests\Unit\Services\AccountServices;

use App\DTO\Accounts\AccountData;
use App\DTO\Accounts\UserData;
use App\Models\AccountModels\Account;
use App\Models\AccountModels\User;
use App\Repositories\RepositoryContracts\AccountRepositoryContract;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use App\Services\AccountServices\AccountService;
use App\Services\ServiceContracts\AccountServiceContract;
use Hash;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(AccountService::class)]
class AccountServiceTest extends TestCase
{
    use RefreshDatabase;
    private AccountServiceContract $accountService;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

    }


    /**
     * @param array $userData
     * @return void
     */
    #[Test]
    public function canServiceCreateUser(): void
    {
        // not using factory because this is a NEW user with no entity yet
        $name = fake()->name;
        $email = fake()->email;
        $pass = Hash::make(fake()->shuffleString);
        $userData = UserData::from(['name' => $name, 'email' => $email]);
        $userRepoMock = $this->partialMock(UserRepositoryContract::class, function (MockInterface $mock) use ($userData, $pass) {
            $mock->shouldReceive('createNewUser')->with($userData, $pass, true)->once()->andReturn($userData);
        });
        $accountRepoMock = $this->partialMock(AccountRepositoryContract::class, function (MockInterface $mock) use ($userData, $pass) {
            $mock->shouldReceive('createNewAccountFromUser')->once()->with($userData);
        });
        $accountService = $this->app->makeWith(AccountServiceContract::class, [
            'accountRepository' => $accountRepoMock,
            'userRepository' => $userRepoMock,
        ]);
        $newUser = $accountService->createUser($userData, password: $pass);
        $this->assertEquals($newUser->name, $name);
        $this->assertEquals($newUser->email, $email);
    }

    /**
     * @throws BindingResolutionException
     */
    #[Test]
    public function canServiceCreateAccount(): void
    {
        $premadeUser = UserData::fromModel(User::factory()->create());
        $premadeAccount = AccountData::fromModel(Account::factory()->create(['user_id' => $premadeUser->id]));

        $accountRepositoryMock = $this->partialMock(AccountRepositoryContract::class, function (MockInterface $mock) use ($premadeAccount, $premadeUser) {
            $mock->shouldReceive('createNewAccountFromUser')->with($premadeUser)->once()->andReturn($premadeAccount);
        });

        /** @var AccountServiceContract $accountService */
        $accountService = $this->app->makeWith(AccountServiceContract::class, [
            'accountRepository' => $accountRepositoryMock
        ]);
        $accountData = $accountService->createAccount($premadeUser);
        $this->assertEquals($accountData->userId, $premadeUser->id);
        $this->assertFalse($accountData->isLocked);
        $this->assertFalse($accountData->isMfaEnabled);

    }
}
