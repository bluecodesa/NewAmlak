<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\Role;
use App\Models\City;
use App\Models\District;
use App\Models\Owner;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionTypeRole;
use App\Models\SystemInvoice;
use App\Models\Unit;
use Carbon\Carbon;
use App\Services\Admin\SubscriptionService;
use App\Services\RegionService;
use App\Services\CityService;

class HomeController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $cityService;



    public function __construct(SubscriptionService $subscriptionService, RegionService $regionService, CityService $cityService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $user = $request->user();
        $brokerId = auth()->user()->UserBrokerData->id;
        $numberOfowners = Owner::where('broker_id', $brokerId)->count();
        $numberOfUnits = Unit::where('broker_id', $brokerId)->count();

        if ($user && $user->is_broker && $user->UserBrokerData) {
            $subscription = $user->UserBrokerData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }

        $subscriber = Subscription::where('broker_id', $brokerId)->first();

        //
        $sectionNames = [];
        if ($subscriber) {
            $subscriptionType = SubscriptionType::find($subscriber->subscription_type_id);
            $hasRealEstateGallerySection = $subscriptionType->sections()->get();
            $sectionNames = $hasRealEstateGallerySection->pluck('name')->toArray();
        }

        //
        // $subscriber = $this->subscriptionService->findSubscriptionById($brokerId);
        $UserSubscriptionTypes = SubscriptionType::where('is_deleted', 0)->whereHas('roles', function ($query) {
            $query->where('name', 'RS-Broker');
        })
            ->where('price', '>', 0)
            ->get();

        return view('Broker.dashboard',  get_defined_vars());
    }

    function ViewInvoice()
    {
        return view('Home.Payments.inc._ViewInvoice');
    }

    public function GetCitiesByRegion($id)
    {
        $cities = City::where('region_id', $id)->get();
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }

    public function GetDistrictsByCity($id)
    {
        $districts = District::where('city_id', $id)->get();
        return view('Admin.settings.Region.inc._district', get_defined_vars());
    }

    function UpdateSubscription($id)
    {
        $SubscriptionType = SubscriptionType::find($id);

        $subscription = Auth::user()->UserBrokerData->UserSubscriptionPending;

        $subscription->update(['subscription_type_id' => $id, 'total' => $SubscriptionType->price]);

        $Invoice  = Auth::user()->UserBrokerData->UserSystemInvoicePending;

        $Invoice->update(['amount' => $SubscriptionType->price, 'subscription_name' => $SubscriptionType->name, 'period' => $SubscriptionType->period, 'period_type' => $SubscriptionType->period_type]);
    }
}
