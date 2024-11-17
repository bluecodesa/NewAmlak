<?php

namespace App\Http\Controllers\Employee;

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
use App\Services\Broker\OwnerService;
use App\Services\Broker\UnitService;
use App\Services\Broker\GalleryService;
use App\Services\Broker\UnitInterestService;
use App\Services\PropertyUsageService;
use App\Services\Admin\SectionService;





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
        SectionService $SectionService
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

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        Auth::user()->assignRole('Office-Employee');
        // return view('home',   get_defined_vars());
        return view('Office.Employee.dashboard',   get_defined_vars());

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
}
