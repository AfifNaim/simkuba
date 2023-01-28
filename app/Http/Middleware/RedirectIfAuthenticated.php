<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (\auth($guard)->user()->hasRole('Super Admin')){
                    return redirect(route('companies.index'));
                }

                if (\auth($guard)->user()->hasRole('Admin')){
                    return redirect(route('dashboard'));
                }

                if (\auth($guard)->user()->hasRole('User')){
                    return redirect(route('cash-books.index'));
                }
            }
        }

        return $next($request);
    }
}
