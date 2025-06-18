<?php

namespace App\Listeners\Audit;

use App\Models\EventModels\UserLogoutEvent;
use Illuminate\Auth\Events\Logout;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;
use Request;

#[CodeCoverageIgnore]
class UserLogoutListener
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
    public function handle(Logout $event): void
    {
        $userLogout = new UserLogoutEvent();
        $userLogout->user_uuid = $event->user->uuid;
        $userLogout->from_ip = Request::ip();
        $userLogout->save();
    }
}
