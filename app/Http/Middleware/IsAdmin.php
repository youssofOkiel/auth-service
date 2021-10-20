<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $isAdmin = false;

        $user = User::find(Auth::user()->id);

        foreach ($user->roles as $role) {

            if ($role->title == 'Admin') {
                $isAdmin = true;
            }
        }

        if (Auth::user() &&  $isAdmin) {
            return $next($request);
        }

        return response()->json(['status' => 'Not permitted']);
    }
}
