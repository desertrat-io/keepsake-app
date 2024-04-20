<?php

namespace App\Http\Middleware;

use App\DTO\Accounts\UserData;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class AddUserContext
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userViaEloquent = Auth::user()->load('account');
        Context::add('user_data', new UserData(
            id: $userViaEloquent->id,
            uuid: $userViaEloquent->uuid,
            account: $userViaEloquent->account,
            name: $userViaEloquent->name,
            email: $userViaEloquent->email,
            emailVerifiedAt: $userViaEloquent->email_verified_at,
            createdAt: $userViaEloquent->created_at,
            updatedAt: $userViaEloquent->updated_at,
            deletedAt: $userViaEloquent->deleted_at,
            isDeleted: $userViaEloquent->is_deleted
        ));
        return $next($request);
    }
}
