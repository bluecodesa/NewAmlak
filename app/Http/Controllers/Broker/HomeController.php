<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
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

        // Pass the $pendingPayment variable to the view
        return view('home', ['pendingPayment' => $pendingPayment]);
    }
}