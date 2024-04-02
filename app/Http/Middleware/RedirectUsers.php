<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (auth()->check()) {
            // Check if the authenticated user is a broker
            if (auth()->user()->is_broker) {
                return redirect()->route('Broker.home');
            }
            // Check if the authenticated user is an office user
            elseif (auth()->user()->is_office) {
                return redirect()->route('Office.home');
            }
            // Check if the authenticated user is an admin
            // elseif (auth()->user()->is_admin) {
            //     // Handle admin redirection if needed
            //     // For example, you can redirect admins to a specific route
            //     // return redirect()->route('admin.dashboard');
            // }
        }

        return $next($request);
    }
}
