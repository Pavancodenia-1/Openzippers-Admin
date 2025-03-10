<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthStatus
{
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('admin.auth.login')->with('warning', 'Please login first.');
    //     }

    //     $user = Auth::user();
    //     if ($user && $user->status === 'blocked') {
    //         Auth::guard('web')->logout();
    //         return redirect()->route('admin.auth.login')->with('warning', 'Your account is blocked.');
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) { // Use 'admin' guard
            return redirect()->route('admin.auth.login')->with('warning', 'Please login first.');
        }
    
        $user = Auth::guard('admin')->user();
        if ($user && $user->status === 'blocked') {
            Auth::guard('admin')->logout(); // Logout using 'admin' guard
            return redirect()->route('auth.login')->with('warning', 'Your account is blocked.');
        }

        return $next($request);
    }
}
