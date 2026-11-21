<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();

        if ($user && $user->role === 'admin' && strtolower($user->status) === 'active') {
            session([
                'user_id' => $user->user_id,
                'admin_id' => $user->user_id,
                'name' => $user->name,
                'admin_name' => $user->name,
                'email' => $user->email,
                'admin_email' => $user->email,
                'role' => 'admin',
            ]);
            return $next($request);
        }

        if (session('role') === 'admin' && (session('admin_id') || session('user_id'))) {
            return $next($request);
        }

        return redirect()->route('admin.login')->with('error', 'Please log in to access the admin portal.');
    }
}
