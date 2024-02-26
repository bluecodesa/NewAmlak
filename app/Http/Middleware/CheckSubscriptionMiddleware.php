<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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

        if (Auth::user()->is_broker) {
            $subscription =      Auth::user()->UserBrokerData->UserSubscriptionPending;
            if ($subscription) {
                // return    redirect()->route('Broker.home');
            }
        }

        if (Auth::check()) {
            $url = URL::current();
            $notifications = auth()->user()->unreadNotifications
                ->filter(function ($notification) use ($url) {
                    return data_get($notification->data, 'url') === $url;
                });
            $notifications->each(function ($notification) {
                $notification->markAsRead();
            });
        }
        return $next($request);
    }
}
