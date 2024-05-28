<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {

        $user2 = auth()->user()->id;
        $user = User::find($user2);
        if ($user && $user->hasRole('admin') && $user2 == $request->user_id) {
            return $next($request);
        }

        throw UnauthorizedException::forRoles(['admin']);
    }
}
