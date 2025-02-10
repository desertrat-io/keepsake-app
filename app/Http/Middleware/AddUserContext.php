<?php

namespace App\Http\Middleware;

use App\DTO\Accounts\UserData;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

/**
 * @codeCoverageIgnore 
 */
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
        Context::add(
            'user_data',
            UserData::from($userViaEloquent)

        );
        return $next($request);
    }
}
