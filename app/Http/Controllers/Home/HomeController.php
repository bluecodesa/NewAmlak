<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Office;
use App\Models\Region;
use App\Models\Subscription;
use App\Models\SubscriptionType;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Home.home');
    }

    public function createBroker()
    {
        $Regions = Region::all();
        $cities = City::all();
        $subscriptionTypes = SubscriptionType::all();
        return view('Home.Auth.broker.create', get_defined_vars());
    }
    public function createOffice()
    {
        $Regions = Region::all();
        $cities = City::all();
        $subscriptionTypes = SubscriptionType::all();
        return view('Home.Auth.office.create', get_defined_vars());
    }

}
