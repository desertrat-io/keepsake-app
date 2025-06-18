<?php

namespace App\Listeners\Audit;

use App\Models\EventModels\UserLoginEvent;
use Illuminate\Auth\Events\Login;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;
use Request;

#[CodeCoverageIgnore]
class UserLoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $userLogin = new UserLoginEvent();
        $userLogin->user_uuid = $event->user->uuid;
        $userLogin->from_ip = Request::ip();
        $userLogin->save();
    }
}
