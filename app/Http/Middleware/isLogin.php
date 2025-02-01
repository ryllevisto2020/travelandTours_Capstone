<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isLoginClient = Auth::guard("loginAuthClient")->check();
        $isLoginEmp = true;
        if (!$isLoginClient || !$isLoginEmp) {
            return redirect()->route('login');
        } else {
            return $next($request);
        }
    }
}
