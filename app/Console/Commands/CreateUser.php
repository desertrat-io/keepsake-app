<?php

namespace App\Console\Commands;

use App\DTO\Accounts\UserData;
use App\Services\ServiceContracts\AccountServiceContract as AccountService;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keepsake:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user and account for testing';

    public function __construct(private readonly AccountService $accountService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        do {
            $password = $this->secret('Password');
            $confirmPassword = $this->secret('Confirm Password');
            if ($password !== $confirmPassword) {
                $this->error('Passwords don\'t match, try again');
            }
        } while ($password !== $confirmPassword);

        $result = $this->accountService->createUser(
            UserData::from(collect(['name' => $name, 'email' => $email, 'password' => $password]))
        );

        $this->info('User created with id: ' . $result->id);
    }
}
