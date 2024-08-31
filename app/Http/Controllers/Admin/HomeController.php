<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\Office;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Property;
use App\Models\RealEstateRequest;
use App\Models\Renter;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\Unit;
use App\Models\UnitInterest;
use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $numberOfOwners = Owner::all()->count();


        $totalUsers = $numberOfOffices + $numberOfBrokers + $numberOfPropertyFinders + $numberOfRenters;

        $officePercentage = $totalUsers > 0 ? ($numberOfOffices / $totalUsers) * 100 : 0;
        $brokerPercentage = $totalUsers > 0 ? ($numberOfBrokers / $totalUsers) * 100 : 0;
        $propertyFinderPercentage = $totalUsers > 0 ? ($numberOfPropertyFinders / $totalUsers) * 100 : 0;
        $renterPercentage = $totalUsers > 0 ? ($numberOfRenters / $totalUsers) * 100 : 0;
        $ownerPercentage = $totalUsers > 0 ? ($numberOfOwners / $totalUsers) * 100 : 0;



        $visitorData =Visitor::select(DB::raw('DAYNAME(visited_at) as day'), DB::raw('COUNT(id) as count'))
        ->whereBetween('visited_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->groupBy('day')
        ->orderBy(DB::raw('FIELD(day, "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday")'))
        ->get();
        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $visitorCounts = [];

        foreach ($days as $day) {
            $visitorCounts[$day] = $visitorData->firstWhere('day', $day)->count ?? 0;
        }


        //month

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $visitorDataMonth = Visitor::select(
                DB::raw('DAY(visited_at) as day'),
                DB::raw('COUNT(id) as count')
            )
            ->whereBetween('visited_at', [$startOfMonth, $endOfMonth])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Generate an array with all days of the month initialized to 0
        $daysInMonth = range(1, $endOfMonth->day);
        $visitorCountsMonth = array_fill_keys($daysInMonth, 0);

        // Populate the array with actual visitor counts
        foreach ($visitorDataMonth as $data) {
            $visitorCountsMonth[$data->day] = $data->count;
        }

        $cities = City::all(); // Assuming you have a City model

        //end dashbard
        return view('home', get_defined_vars());
    }

    function ContactUs()
    {
        $messages = ContactUs::latest('created_at')->get();
        return view('Admin.supports.ContactUs.index', get_defined_vars());
    }

    public function getCityData($cityId) {
        $unitsCount = Unit::where('city_id', $cityId)->count();
        $propertiesCount = Property::where('city_id', $cityId)->count();
        $projectsCount = Project::where('city_id', $cityId)->count();

        return response()->json([
            'units_count' => $unitsCount,
            'properties_count' => $propertiesCount,
            'projects_count' => $projectsCount,
        ]);
    }

    public function switchRole($role)
    {

        $roles = Role::all();


        if (!$roles->contains('name', $role)) {
            return redirect()->route('home')->with('error', 'Role not found');
        }


        $user = Auth::user();


        if ($user->hasRole($role)) {

            Auth::logout();


            Auth::loginUsingId($user->id);

            session(['active_role' => $role]);


            switch ($role) {
                case 'Owner':
                    return redirect()->route('PropertyFinder.home');
                case 'Property-Finder':
                    return redirect()->route('PropertyFinder.home');
                case 'Renter':
                    return redirect()->route('PropertyFinder.home');
                case 'RS-Broker':
                    return redirect()->route('Broker.home');
                case 'Office':
                    return redirect()->route('Office.home');
                default:
                    return redirect()->route('Home.home');
            }
        } else {
            return redirect()->route('home')->with('error', 'You do not have permission for this role');
        }
    }



}
