<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Subscription;

class PendingPaymentPopup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    $user = $request->user();
    $pendingPayment = false;

    if ($user && ($user->is_office || $user->is_broker)) {
        if ($user->is_office && $user->UserOfficeData) {
            $subscription = Subscription::where('office_id', $user->UserOfficeData->id)->first();
        } elseif ($user->is_broker && $user->UserBrokerData) {
            $subscription = Subscription::where('broker_id', $user->UserBrokerData->id)->first();
        }

        if (isset($subscription) && $subscription->status === 'pending') {
            $pendingPayment = true;
        }
    }

    return $next($request);
}

}
