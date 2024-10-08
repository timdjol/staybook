<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsBuh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->is_admin == 3) {
            return $next($request);
        }
        session()->flash('warning', 'У вас недостаточно прав бухгалтера!');
        Auth::logout();
        return redirect()->back();
    }
}
