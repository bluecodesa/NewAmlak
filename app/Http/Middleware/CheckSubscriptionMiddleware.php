<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subscriptions = Subscription::where('end_date', '<=', now()->format('Y-m-d'))->get();
        foreach ($subscriptions as  $subscription) {
            $subscription->update([
                'status' => 'expired',
            ]);
        }
        return $next($request);
    }
}
