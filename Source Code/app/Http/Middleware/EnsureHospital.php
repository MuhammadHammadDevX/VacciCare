<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHospital
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hospitalUser = Auth::guard('hospital')->user();

        if ($hospitalUser) {
            session([
                'hospital_id' => $hospitalUser->id,
                'user_id' => $hospitalUser->id,
                'hospital_name' => $hospitalUser->hospital_name,
                'hospital_email' => $hospitalUser->email,
                'role' => 'hospital',
            ]);
            return $next($request);
        }

        $webUser = Auth::guard('web')->user();
        if ($webUser && ($webUser->role === 'hospital' || $webUser->role === 'vaccinator') && strtolower($webUser->status) === 'active') {
            session([
                'hospital_id' => $webUser->user_id,
                'user_id' => $webUser->user_id,
                'hospital_name' => $webUser->name,
                'hospital_email' => $webUser->email,
                'role' => $webUser->role,
            ]);
            return $next($request);
        }

        if (session('role') === 'hospital' && (session('hospital_id') || session('user_id'))) {
            return $next($request);
        }

        return redirect()->route('hospital.login')->with('error', 'Please log in to access the hospital portal.');
    }
}
