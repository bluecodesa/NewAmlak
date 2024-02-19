<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use App\Models\Subscription;


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

        if ($user && $user->is_office && $user->UserOfficeData) {
            $subscription = $user->UserOfficeData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }

        $UserSubscriptionTypes = SubscriptionType::whereHas('roles', function ($query) {
            $query->where('name', 'Office-Admin');
        })
        ->where('price', '>', 0)
        ->get();

        return view('home',   get_defined_vars());
    }

    public function GetCitiesByRegion($id)
    {
        $cities = City::where('region_id', $id)->get();
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }
}
