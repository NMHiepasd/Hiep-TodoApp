<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckRole
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
        if (auth()->user() &&  auth()->user()->role == User::ROLE_ADMIN) {
            return $next($request);
        }

        return redirect('home')->with('error',"You don't have admin access.");
    }
}
