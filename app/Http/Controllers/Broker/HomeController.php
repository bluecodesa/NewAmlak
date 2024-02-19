<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\City;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionTypeRole;


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

    $brokerSubscriptionTypes = SubscriptionType::whereIn('id', function ($query) {
        $query->select('subscription_type_id')
            ->from('subscription_type_roles')
            ->whereIn('role_id', function ($subquery) {
                $subquery->select('id')
                    ->from('roles')
                    ->where('name', 'RS-Broker');
            });
    })->get();

    return view('home',  get_defined_vars());
    }

    // $user = Auth::user();
    // $pendingPayment = false;

    // if ($user && ($user->is_office || $user->is_broker)) {
    //     $subscription = $user->UserBrokerData()->UserSubscriptionPending();

    //     if ($subscription) {
    //         $pendingPayment = true;
    //     }
    // }
    public function GetCitiesByRegion($id)
    {
        $cities = City::where('region_id', $id)->get();
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }
}
