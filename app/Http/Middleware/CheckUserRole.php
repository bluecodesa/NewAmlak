<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check()) {
            // Check if the user's role flag matches the required role
            switch ($role) {
                case 'admin':
                    if (Auth::user()->is_admin) {
                        return $next($request);
                    }
                    break;
                case 'broker':
                    if (Auth::user()->is_broker) {
                        return $next($request);
                    }
                    break;
                case 'office':
                    if (Auth::user()->is_office) {
                        return $next($request);
                    }
                    break;
            }
        }

        // If the user is not authenticated or doesn't have the required role, redirect to login page
        return redirect()->route('Admin.home');
        }
}
