<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Owner;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\SystemInvoice;
use App\Models\UnitInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\RegionService;
use App\Services\CityService;
use App\Services\Broker\OwnerService;
use App\Services\Broker\UnitService;
use App\Services\Broker\GalleryService;
use App\Services\PropertyUsageService;




class HomeController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $cityService;
    protected $ownerService;
    protected $UnitService;
    protected $SubscriptionTypeService;
    protected $propertyUsageService;

    protected $galleryService;






    public function __construct(
        UnitService $UnitService,
        SubscriptionService $subscriptionService,
        RegionService $regionService,
        CityService $cityService,
        OwnerService $ownerService,
        SubscriptionTypeService $SubscriptionTypeService,
        GalleryService $galleryService,
        PropertyUsageService $propertyUsageService
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->ownerService = $ownerService;
        $this->UnitService = $UnitService;
        $this->galleryService = $galleryService;
        $this->propertyUsageService = $propertyUsageService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // return Auth::user()->UserBrokerData->UserSubscriptionPending->status;
        $user = $request->user();
        $brokerId = auth()->user()->UserBrokerData->id;
        $numberOfowners = $this->ownerService->getAllByBrokerId($brokerId)->count();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $numberOfUnits = $this->UnitService->getAll($brokerId)->count();
        $counts = $this->UnitService->countUnitsForBroker($brokerId);
        $residentialCount = $counts['residential'];
        $nonResidentialCount = $counts['non_residential'];
        $numberOfInterests = UnitInterest::where('user_id', auth()->user()->id)->count();
        $numberOfVacantUnits = $this->UnitService->getAll($brokerId)->where('status', 'vacant')->count();
        $numberOfRentedUnits = $this->UnitService->getAll($brokerId)->where('status', 'rented')->count();
        if ($user && $user->is_broker && $user->UserBrokerData) {
            $subscription = $user->UserBrokerData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }

        $subscriber = $this->subscriptionService->findSubscriptionByBrokerId($brokerId);
        $SubscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($subscriber->subscription_type_id);

        //
        $sectionNames = [];
        if ($subscriber) {
            $subscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($subscriber->subscription_type_id);
            $hasRealEstateGallerySection = $subscriptionType->sections()->get();
            $sectionNames = $hasRealEstateGallerySection->pluck('name')->toArray();
        }

        //
        $UserSubscriptionTypes = $this->SubscriptionTypeService->getUserSubscriptionTypes();

        //statistics calc

        $startDate = \Carbon\Carbon::parse($subscriber->start_date);
        $endDate = \Carbon\Carbon::parse($subscriber->end_date);
        $now = \Carbon\Carbon::now();
        $daysUntilEnd = $now->diffInDays($endDate, false); // Calculate remaining days
        $hoursUntilEnd = $now->diffInHours($endDate->copy()->subDays($daysUntilEnd), false); // Get remaining hours
        $minutesUntilEnd = $now->diffInMinutes($endDate, false); // Get remaining minutes
        $numOfDays = $endDate->diffInDays($startDate);
        if ($numOfDays == 0) {
            $prec = 100;
        } else {

            $prec = ($daysUntilEnd / $numOfDays) * 100;
        }

        // Now you can use $prec for further calculations or output

        //
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

        if (!$Invoice) {
            SystemInvoice::create([
                'broker_id' => $subscription->broker_id,
                'office_id' => $subscription->office_id,
                'amount' => $SubscriptionType->price,
                'subscription_name' => $SubscriptionType->name,
                'period' => $SubscriptionType->period,
                'period_type' => $SubscriptionType->period_type,
                'invoice_ID' => 'INV_' . uniqid(),
                'status' => 'pending'
            ]);
        } else {
            $Invoice->update(['amount' => $SubscriptionType->price, 'subscription_name' => $SubscriptionType->name, 'period' => $SubscriptionType->period, 'period_type' => $SubscriptionType->period_type]);
        }
    }
}
