<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureParent
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();

        if ($user && $user->role === 'parent' && strtolower($user->status) === 'active') {
            $parent = $user->parentProfile;
            session([
                'user_id' => $user->user_id,
                'parent_id' => $parent ? $parent->parent_id : $user->user_id,
                'name' => $user->name,
                'parent_name' => $parent && !empty($parent->parent_name) ? $parent->parent_name : $user->name,
                'email' => $user->email,
                'role' => 'parent',
            ]);
            return $next($request);
        }

        if (session('role') === 'parent' && (session('parent_id') || session('user_id'))) {
            return $next($request);
        }

        return redirect()->route('signin')->with('error', 'Please log in as a parent.');
    }
}
