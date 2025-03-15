<?php

namespace Tests\Unit\Console;

use App\Console\Commands\CreateUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(CreateUser::class)]
class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function canCreateUser(): void
    {
        $this->artisan('keepsake:create-user')
            ->expectsQuestion('Name', 'mike')
            ->expectsQuestion('Email', 'mike@desertrat.io')
            ->expectsQuestion('Password', 'abc')
            ->expectsQuestion('Confirm Password', 'abc')
            ->expectsOutputToContain('User created with id: ')
            ->assertExitCode(0);
    }

    #[Test]
    public function detectsPasswordMismatch(): void
    {
        $this->artisan('keepsake:create-user')
            ->expectsQuestion('Name', 'mike')
            ->expectsQuestion('Email', 'mike@desertrat.io')
            ->expectsQuestion('Password', 'abc')
            ->expectsQuestion('Confirm Password', 'def')
            ->expectsOutput('Passwords don\'t match, try again')
            ->expectsQuestion('Password', 'abc')
            ->expectsQuestion('Confirm Password', 'abc')
            ->expectsOutputToContain('User created with id: ')
            ->assertExitCode(0);
    }
}
