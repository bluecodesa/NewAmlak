<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\ContactUs;
use App\Models\Office;
use App\Models\RealEstateRequest;
use App\Models\Renter;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\UnitInterest;
use App\Models\User;
use Carbon\Carbon;

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
        $pendingPayment = false;
        //dashbard
        $numBroker = Broker::all()->count();
        $numOffice = Office::all()->count();
        $numRenter = Renter::all()->count();
        $numProertyFinder = User::where('is_property_finder' , 1 )->get()->count();
        $unit_interests = UnitInterest::all()->count();
        $RealEstateRequests = RealEstateRequest::all()->count();
        $tickets = Ticket::where('status', '!=', 'closed')->count();
        $subscriptions = Subscription::whereDate('created_at', Carbon::today())->get()->count();
        $subscriptionsEndingToday = Subscription::whereDate('end_date', Carbon::today())->get()->count();

        $numberOfOffices = User::where('is_office', 1)->count();
        $numberOfBrokers = User::where('is_broker', 1)->count();
        $numberOfPropertyFinders = User::where('is_property_finder', 1)->count();
        $numberOfRenters = User::where('is_renter', 1)->count();

        $totalUsers = $numberOfOffices + $numberOfBrokers + $numberOfPropertyFinders + $numberOfRenters;

$officePercentage = $totalUsers > 0 ? ($numberOfOffices / $totalUsers) * 100 : 0;
$brokerPercentage = $totalUsers > 0 ? ($numberOfBrokers / $totalUsers) * 100 : 0;
$propertyFinderPercentage = $totalUsers > 0 ? ($numberOfPropertyFinders / $totalUsers) * 100 : 0;
$renterPercentage = $totalUsers > 0 ? ($numberOfRenters / $totalUsers) * 100 : 0;



        //end dashbard
        return view('home', get_defined_vars());
    }

    function ContactUs()
    {
        $messages = ContactUs::latest('created_at')->get();
        return view('Admin.supports.ContactUs.index', get_defined_vars());
    }
}
