<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Models\City;
use App\Models\District;
use App\Models\FalLicenseUser;
use App\Models\Gallery;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Property;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionType;
use App\Models\SystemInvoice;
use App\Models\UnitInterest;
use App\Notifications\Admin\LicenseExpiryNotification;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Visitor;
use App\Services\Admin\RegionService as AdminRegionService;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\RegionService;
use App\Services\CityService;
use App\Services\Broker\OwnerService;
use App\Services\Broker\UnitService;
use App\Services\Broker\GalleryService;
use App\Services\Broker\UnitInterestService;
use App\Services\PropertyUsageService;
use App\Services\Admin\SectionService;
use App\Services\Broker\TicketService;
use App\Services\RealEstateRequestService;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $RegionService;
    protected $districtService;
    protected $cityService;
    protected $ownerService;
    protected $UnitService;
    protected $SubscriptionTypeService;
    protected $propertyUsageService;

    protected $galleryService;
    protected $systemInvoiceRepository;
    protected $unitInterestService;
    protected $SectionService;

    protected $RealEstateRequestService;

    protected $ticketService;


    public function __construct(
        TicketService $ticketService,
        SystemInvoiceRepositoryInterface $systemInvoiceRepository,
        UnitService $UnitService,
        SubscriptionService $subscriptionService,
        RegionService $regionService,
        AdminRegionService $RegionService,
        DistrictService $districtService,
        CityService $cityService,
        OwnerService $ownerService,
        SubscriptionTypeService $SubscriptionTypeService,
        GalleryService $galleryService,
        PropertyUsageService $propertyUsageService,
        UnitInterestService $unitInterestService,
        SectionService $SectionService,
        RealEstateRequestService $RealEstateRequestService,

    ) {
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;
        $this->regionService = $regionService;
        $this->RegionService = $RegionService;
        $this->districtService = $districtService;
        $this->cityService = $cityService;
        $this->ownerService = $ownerService;
        $this->UnitService = $UnitService;
        $this->galleryService = $galleryService;
        $this->propertyUsageService = $propertyUsageService;
        $this->systemInvoiceRepository = $systemInvoiceRepository;
        $this->unitInterestService = $unitInterestService;
        $this->SectionService = $SectionService;
        $this->ticketService = $ticketService;
        $this->RealEstateRequestService = $RealEstateRequestService;

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $user = $request->user();
        $roles = Role::all();
        $userRoles = $roles->filter(function ($role) use ($user) {
            return $user->hasRole($role->name);

        });
        $brokerId = auth()->user()->UserBrokerData->id;
        $numberOfowners = $this->ownerService->getAllByBrokerId($brokerId)->count();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $numberOfUnits = $this->UnitService->getAll($brokerId)->count();
        $counts = $this->UnitService->countUnitsForBroker($brokerId);
        $residentialCount = $counts['residential'];
        $nonResidentialCount = $counts['non_residential'];
        $numberOfInterests = $this->unitInterestService->getNumberOfInterests();
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
        $UserSubscriptionTypes = $this->SubscriptionTypeService->getUserSubscriptionTypes()->where('is_deleted', 0)->where('status', 1);

        //statistics calc

        $start_date = \Carbon\Carbon::parse($subscriber->start_date);
        $end_date = \Carbon\Carbon::parse($subscriber->end_date);
        $now = now();

        $numOfDays = $end_date->diffInDays($start_date);
        $elapsed_days = $now->diffInDays($start_date);
        $daysUntilEnd = $numOfDays - $elapsed_days;

        $hoursUntilEnd = $now->diffInHours($end_date->copy()->subDays($daysUntilEnd), false);
        $minutesUntilEnd = $now->diffInMinutes($end_date, false);

        // $startDate = \Carbon\Carbon::parse($subscriber->start_date);
        // $endDate = \Carbon\Carbon::parse($subscriber->end_date);
        // $now = \Carbon\Carbon::now();
        // $daysUntilEnd = $now->diffInDays($endDate, false); // Calculate remaining days
        // $hoursUntilEnd = $now->diffInHours($endDate->copy()->subDays($daysUntilEnd), false); // Get remaining hours
        // $minutesUntilEnd = $now->diffInMinutes($endDate, false); // Get remaining minutes
        // $numOfDays = $endDate->diffInDays($startDate);
        if ($numOfDays == 0) {
            $prec = 100;
        } else {

            $prec = ($daysUntilEnd / $numOfDays) * 100;
            $prec = round($prec, 1);
        }


        $gallery = $this->galleryService->findByBrokerId($brokerId);
        $visitorCount = 0;

        if ($gallery !== null) {
            $visitorCount += $gallery->visitors()->distinct('ip_address')->count('ip_address');
        }

        $tickets = $this->ticketService->getUserTickets(auth()->id());
        $requests = $this->RealEstateRequestService->getAll();
        Auth::user()->assignRole('RS-Broker');
        session(['active_role' => 'RS-Broker']);

        $Licenses = FalLicenseUser::where('ad_license_status', 'valid')->get();

        foreach ($Licenses as $License) {
            $expiryDate = \Carbon\Carbon::parse($License->ad_license_expiry);
            $now = \Carbon\Carbon::now();

            if ($expiryDate->diffInDays($now) <= 30 && $expiryDate > $now && !$License->notification_sent) {
                $this->notifyBroker($License, __('30 days left until expiration') .$License->falData->name );
                $License->update(['notification_sent' => true]);
            }

            if ($expiryDate < $now ) {
                $License->update(['ad_license_status' => 'invalid', 'notification_sent' => true]);
                $this->notifyBroker($License, __('Your has expired') .$License->falData->name . __(', please renew your license as soon as possible.'));
            }
        }

           // اجلب عدد الإعلانات الصالحة المنشورة
           $x = Project::where('office_id', $brokerId)
           ->where('ad_license_status', 'Valid')->count()
           + Property::where('office_id', $brokerId)
           ->where('ad_license_status', 'Valid')->count()
           + Unit::where('office_id', $brokerId)
           ->where('ad_license_status', 'Valid')->count();
       //             $x= Unit::where('office_id', $officeId)->where('ad_license_status', 'Valid')->count();
       // dd($x);
           // اجلب عدد المشاهدات لكل الإعلانات الخاصة بالمستخدم
           $y = Visitor::where(function($query) use ($brokerId) {
               $query->whereIn('project_id', Project::where('office_id', $brokerId)->pluck('id'))
                       ->orWhereIn('property_id', Property::where('office_id', $brokerId)->pluck('id'))
                       ->orWhereIn('unit_id', Unit::where('office_id', $brokerId)->pluck('id'));
           })
           ->whereBetween('visited_at', [$start_date, $end_date]) // Filter by subscription dates
           ->count();


        return view('Broker.dashboard',  get_defined_vars());
    }

    protected function notifyBroker(FalLicenseUser $license, $message)
    {
        $broker = $license->userData;
        if ($broker && $broker->is_broker) {
            Notification::send($broker, new LicenseExpiryNotification( $license ,$message));
        }
    }


    function ViewInvoice()
    {
        return view('Home.Payments.inc._ViewInvoice');
    }

    public function GetCitiesByRegion($id)
    {
        // $cities = City::where('region_id', $id)->get();
        $cities = $this->RegionService->getCityByRegionId($id);
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }

    public function GetDistrictsByCity($id)
    {
        // $districts = District::where('city_id', $id)->get();
        $districts = $this->districtService->getDistrictsByCity($id);

        return view('Admin.settings.Region.inc._district', get_defined_vars());
    }


    function UpdateSubscription($id)
    {
        // $SubscriptionType = SubscriptionType::find($id);
        $SubscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($id);

        $subscription = auth()->user()->UserBrokerData->UserSubscriptionPending;

        $subscription->update(['subscription_type_id' => $id, 'total' => $SubscriptionType->price, 'status' => 'pending']);

        $Invoice  =  auth()->user()->UserBrokerData->UserSystemInvoicePending;

        $data = [
            'broker_id' => $subscription->broker_id,
            'office_id' => $subscription->office_id,
            'amount' => $SubscriptionType->price,
            'subscription_name' => $SubscriptionType->name,
            'period' => $SubscriptionType->period,
            'period_type' => $SubscriptionType->period_type,
            'invoice_ID' => 'INV_' . uniqid(),
            'status' => 'pending'
        ];

        if (!$Invoice) {
            $this->systemInvoiceRepository->create($data);
        } else {
            $Invoice->update(['amount' => $SubscriptionType->price, 'subscription_name' => $SubscriptionType->name, 'period' => $SubscriptionType->period, 'period_type' => $SubscriptionType->period_type]);
        }
    }

    public function showSubscription()
    {
        // return Auth::user()->UserBrokerData->UserSystemInvoiceLatest;
        $brokerId = auth()->user()->UserBrokerData->id;
        $subscriber = $this->subscriptionService->findSubscriptionByBrokerId($brokerId);
        $user = Auth::user();
        $start_date = \Carbon\Carbon::parse($subscriber->start_date);
        $end_date = \Carbon\Carbon::parse($subscriber->end_date);
        $now = now();
        if ($user && $user->is_broker && $user->UserBrokerData) {
            $subscription = $user->UserBrokerData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }
        $numOfDays = $end_date->diffInDays($start_date);
        $elapsed_days = $now->diffInDays($start_date);
        $daysUntilEnd = $numOfDays - $elapsed_days;

        $hoursUntilEnd = $now->diffInHours($end_date->copy()->subDays($daysUntilEnd), false);
        $minutesUntilEnd = $now->diffInMinutes($end_date, false);

        // $startDate = \Carbon\Carbon::parse($subscriber->start_date);
        // $endDate = \Carbon\Carbon::parse($subscriber->end_date);
        // $now = \Carbon\Carbon::now();
        // $daysUntilEnd = $now->diffInDays($endDate, false); // Calculate remaining days
        // $hoursUntilEnd = $now->diffInHours($endDate->copy()->subDays($daysUntilEnd), false); // Get remaining hours
        // $minutesUntilEnd = $now->diffInMinutes($endDate, false); // Get remaining minutes
        // $numOfDays = $endDate->diffInDays($startDate);
        if ($numOfDays == 0) {
            $prec = 100;
        } else {

            $prec = ($daysUntilEnd / $numOfDays) * 100;
            $prec = round($prec, 1);
        }

        $brokerId = auth()->user()->UserBrokerData->id;

        $subscription = $this->subscriptionService->findSubscriptionByBrokerId($brokerId);
        if ($brokerId)
            $invoices = $this->systemInvoiceRepository->findByBrokerId($brokerId);
        $UserSubscriptionTypes = $this->SubscriptionTypeService->getUserSubscriptionTypes()->where('is_deleted', 0)->where('status', 1);
        $sections = $this->SectionService->getAll();
             // اجلب عدد الإعلانات الصالحة المنشورة
             $x = Project::where('office_id', $brokerId)
             ->where('ad_license_status', 'Valid')->count()
             + Property::where('office_id', $brokerId)
             ->where('ad_license_status', 'Valid')->count()
             + Unit::where('office_id', $brokerId)
             ->where('ad_license_status', 'Valid')->count();
         //             $x= Unit::where('office_id', $officeId)->where('ad_license_status', 'Valid')->count();
         // dd($x);
             // اجلب عدد المشاهدات لكل الإعلانات الخاصة بالمستخدم
             $y = Visitor::where(function($query) use ($brokerId) {
                 $query->whereIn('project_id', Project::where('office_id', $brokerId)->pluck('id'))
                         ->orWhereIn('property_id', Property::where('office_id', $brokerId)->pluck('id'))
                         ->orWhereIn('unit_id', Unit::where('office_id', $brokerId)->pluck('id'));
             })
             ->whereBetween('visited_at', [$start_date, $end_date]) // Filter by subscription dates
             ->count();

        return view('Broker.Subscription.show', get_defined_vars());
    }

    public function ShowInvoice($id)
    {
        $invoice = $this->systemInvoiceRepository->find($id);

        return view('Broker.Subscription.invoices.show', get_defined_vars());
    }
}
