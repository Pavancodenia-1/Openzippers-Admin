<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAuthController extends Controller
{
    //
    public function index()
    {
        return view('admin.auth.login');
    } 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            if ($user->status === 'blocked') {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.auth.login')->with('warning', 'Your account is blocked.');
            }
            return redirect()->route('admin.dashboard')->with('success', 'Successfully logged in.');
        }
        return redirect()->route('admin.auth.login')->with('error', 'Invalid credentials.');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.auth.login')->with('success', 'Successfully logged out.');
    }
}
