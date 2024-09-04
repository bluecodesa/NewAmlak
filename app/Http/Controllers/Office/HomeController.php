<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Models\City;
use App\Models\District;
use App\Models\Gallery;
use App\Models\Owner;
use App\Models\Subscription;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionType;
use App\Models\SystemInvoice;
use App\Models\UnitInterest;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Services\Admin\RegionService as AdminRegionService;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\RegionService;
use App\Services\CityService;
use App\Services\Office\OwnerService;
use App\Services\Office\UnitService;
use App\Services\Office\GalleryService;
use App\Services\Office\UnitInterestService;
use App\Services\PropertyUsageService;
use App\Services\Admin\SectionService;
use App\Services\Broker\TicketService;
use App\Services\RealEstateRequestService;




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
        TicketService $ticketService,
        RealEstateRequestService $RealEstateRequestService

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
        $officeId = auth()->user()->UserOfficeData->id;
        $numberOfowners = $this->ownerService->getAllByofficeId($officeId)->count();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $numberOfUnits = $this->UnitService->getAll($officeId)->count();
        $counts = $this->UnitService->countUnitsForOffice($officeId);
        $residentialCount = $counts['residential'];
        $nonResidentialCount = $counts['non_residential'];
        $numberOfInterests = $this->unitInterestService->getNumberOfInterests();
        $numberOfVacantUnits = $this->UnitService->getAll($officeId)->where('status', 'vacant')->count();
        $numberOfRentedUnits = $this->UnitService->getAll($officeId)->where('status', 'rented')->count();
        if ($user && $user->is_office && $user->UserOfficeData) {
            $subscription = $user->UserOfficeData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }

        $subscriber = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
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
        if ($numOfDays == 0) {
            $prec = 100;
        } else {

            $prec = ($daysUntilEnd / $numOfDays) * 100;
            $prec = round($prec, 1);
        }


        $gallery = $this->galleryService->findByofficeId($officeId);
        $visitorCount = 0;

        if ($gallery !== null) {
            $visitorCount += $gallery->visitors()->distinct('ip_address')->count('ip_address');
        }

        $tickets = $this->ticketService->getUserTickets(auth()->id());
        $requests = $this->RealEstateRequestService->getAll();
        Auth::user()->assignRole('Office-Admin');
        session(['active_role' => 'Office-Admin']);
        return view('Office.dashboard',  get_defined_vars());
    }

    public function GetCitiesByRegion($id)
    {
        // $cities = City::where('region_id', $id)->get();
        $cities = $this->RegionService->getCityByRegionId($id);
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }

    function ViewInvoice()
    {
        return view('Home.Payments.inc._ViewInvoice');
    }
    public function GetDistrictsByCity($id)
    {
        // $districts = District::where('city_id', $id)->get();
        $districts = $this->districtService->getDistrictsByCity($id);

        return view('Admin.settings.Region.inc._district', get_defined_vars());
    }

    public function showSubscription()
    {
        $officeId = auth()->user()->UserOfficeData->id;
        $subscriber = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
        $user = Auth::user();
        $start_date = \Carbon\Carbon::parse($subscriber->start_date);
        $end_date = \Carbon\Carbon::parse($subscriber->end_date);
        $now = now();
        if ($user && $user->is_office && $user->UserOfficeData) {
            $subscription = $user->UserOfficeData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }
        $numOfDays = $end_date->diffInDays($start_date);
        $elapsed_days = $now->diffInDays($start_date);
        $daysUntilEnd = $numOfDays - $elapsed_days;

        $hoursUntilEnd = $now->diffInHours($end_date->copy()->subDays($daysUntilEnd), false);
        $minutesUntilEnd = $now->diffInMinutes($end_date, false);

        if ($numOfDays == 0) {
            $prec = 100;
        } else {

            $prec = ($daysUntilEnd / $numOfDays) * 100;
            $prec = round($prec, 1);
        }

        $officeId = auth()->user()->UserOfficeData->id;

        $subscription = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
        if ($officeId)
            $invoices = $this->systemInvoiceRepository->findByOfficeId($officeId);
        $UserSubscriptionTypes = $this->SubscriptionTypeService->getUserSubscriptionTypes()->where('is_deleted', 0)->where('status', 1);
        $sections = $this->SectionService->getAll();
        return view('Office.SubscriptionManagement.show', get_defined_vars());
    }

    public function ShowInvoice($id)
    {
        $invoice = $this->systemInvoiceRepository->find($id);

        return view('Office.SubscriptionManagement.invoices.show', get_defined_vars());
    }
}
