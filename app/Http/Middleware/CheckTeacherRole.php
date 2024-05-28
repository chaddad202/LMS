<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckTeacherRole
{
    public function handle(Request $request, Closure $next)
    {

        $user2 = auth()->user()->id;
        $user = User::find($user2);
        if ($user && $user->hasRole('teacher')) {
            return $next($request);
        }
        // return response([
        //     $user2
        // ],401);
        throw UnauthorizedException::forRoles(['teacher']);
    }
}
