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
         if (auth()->user()) {
            if (auth()->user()->is_broker) {
                return redirect()->route('Broker.home');
            }
            elseif (auth()->user()->is_office) {
                return redirect()->route('Office.home');
            }
            elseif (auth()->user()->is_employee) {
                return redirect()->route('Employee.home');
            }
            elseif (auth()->user()->is_property_finder) {
                return redirect()->route('PropertyFinder.home');
            }
            elseif (auth()->user()->is_renter) {
                return redirect()->route('PropertyFinder.home');
            }
            elseif (auth()->user()->is_owner) {
                return redirect()->route('PropertyFinder.home');
            }


        }

        return $next($request);
    }
}
