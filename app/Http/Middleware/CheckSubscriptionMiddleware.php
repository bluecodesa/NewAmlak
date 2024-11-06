<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\SystemInvoice;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $subscriptions = Subscription::whereDate('end_date', '<=', now()->format('Y-m-d'))->get();
        foreach ($subscriptions as  $subscription) {
            if ($subscription->status == 'active') {
                $subscriptionType = SubscriptionType::find($subscription['subscription_type_id']);
                $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');
                $subscription->update([
                    'status' => 'expired',
                    'notified' => 0,
                    'is_end' => 0,
                    'is_start' => 0,
                    'is_new' => 0,
                    'is_suspend' => 0,
                    // 'start_date' => now()->format('Y-m-d'),
                    // 'end_date' => $endDate,
                ]);
                $status = ($subscriptionType->price > 0) ? 'pending' : 'active';

                SystemInvoice::where('broker_id', $subscription->broker_id)
                ->where('status', '!=', 'expired')
                ->update(['status' => 'expired']);

                // SystemInvoice::create([
                //     'broker_id' => $subscription->broker_id,
                //     'office_id' => $subscription->office_id,
                //     'subscription_name' => $subscriptionType->name,
                //     'amount' => $subscriptionType->price,
                //     'subscription_type' => ($subscriptionType->price > 0) ? 'paid' : 'free',
                //     'period' => $subscriptionType->period,
                //     'period_type' => $subscriptionType->period_type,
                //     'status' => $status,
                //     'invoice_ID' => 'INV_' . uniqid(),
                // ]);
            }
        }

        if (Auth::user()->is_broker) {
            $subscription =Auth::user()->UserBrokerData->UserSubscriptionPending;
            $Suspend = Auth::user()->UserBrokerData->UserSubscriptionSuspend;
            if ($subscription) {
                return    redirect()->route('Broker.home');
            }
            if ($Suspend) {
                return    redirect()->route('Broker.home');
            }
        }

        if (Auth::user()->is_office) {
            $subscription =Auth::user()->UserOfficeData->UserSubscriptionPending;
            $Suspend = Auth::user()->UserOfficeData->UserSubscriptionSuspend;
            if ($subscription) {
                return    redirect()->route('Office.home');
            }
            if ($Suspend) {
                return    redirect()->route('Office.home');
            }
        }

        if (Auth::user()->is_owner) {
            $subscription =Auth::user()->UserOwnerData->UserSubscriptionPending;
            $Suspend = Auth::user()->UserOwnerData->UserSubscriptionSuspend;
            if ($subscription) {
                return    redirect()->route('PropertyFinder.home');
            }
            if ($Suspend) {
                return    redirect()->route('PropertyFinder.home');
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
