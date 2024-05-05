<?php

namespace App\Http\Controllers\Broker\Gallary;

use App\Models\Gallery;
use App\Services\Broker\UnitService;
use App\Services\RegionService;
use App\Services\CityService;
use App\Services\AllServiceService;
use App\Services\Broker\BrokerDataService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\ServiceTypeService;
use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Unit;
use App\Models\UnitInterest;
use App\Models\Visitor;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Broker\GalleryService;
use App\Services\Admin\SettingService;
use App\Services\Broker\UnitInterestService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Broker\VisitorService;

class GallaryController extends Controller
{
    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $districtService;
    protected $brokerDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;
    protected $AllServiceService;
    protected $FeatureService;
    protected $galleryService;
    protected $settingService;
    protected $unitInterestService;
    protected $SubscriptionTypeService;

    protected $subscriptionService;
    protected $visitorService;



    public function __construct(
        SettingService $settingService,
        GalleryService $galleryService,
        UnitService $UnitService,
        RegionService $regionService,
        DistrictService $districtService,
        AllServiceService $AllServiceService,
        FeatureService $FeatureService,
        CityService $cityService,
        BrokerDataService $brokerDataService,
        PropertyTypeService $propertyTypeService,
        ServiceTypeService $ServiceTypeService,
        PropertyUsageService $propertyUsageService,
        UnitInterestService $unitInterestService,
        SubscriptionTypeService $SubscriptionTypeService,
        SubscriptionService $subscriptionService,
        VisitorService $visitorService

    ) {
        $this->UnitService = $UnitService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->districtService = $districtService;
        $this->UnitService = $UnitService;
        $this->brokerDataService = $brokerDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;
        $this->galleryService = $galleryService;
        $this->settingService = $settingService;
        $this->unitInterestService = $unitInterestService;
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;
        $this->visitorService = $visitorService;

    }
    public function index()
    {

        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $districts  = $this->districtService->getAllDistrict();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        $brokerId = auth()->user()->UserBrokerData->id;

        // Get all units for the broker
        $units = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        $uniqueIds = $units->pluck('CityData.id')->unique();
        $uniqueNames = $units->pluck('CityData.name')->unique();
        $projectuniqueIds = $units->pluck('PropertyData.ProjectData.id')->filter()->unique();
        $projectUniqueNames = $units->pluck('PropertyData.ProjectData.name')->unique();

        $propertyTypeIds = $units->pluck('PropertyTypeData.id')->filter()->unique();
        $propertyTypeNames = $units->pluck('PropertyTypeData.name')->unique();
        // Filter units based on request parameters
        $adTypeFilter = request()->input('ad_type_filter', 'all');
        $propertyTypeFilter = request()->input('property_type_filter', 'all');
        $typeUseFilter = request()->input('type_use_filter', 'all');
        $cityFilter = request()->input('city_filter', 'all');
        $districtFilter = request()->input('district_filter', 'all');
        $projectFilter = request()->input('project_filter', 'all');
        $dailyFilter = request()->input('daily_filter', 'all');
        $units = $this->galleryService->filterUnits($units, $adTypeFilter, $propertyTypeFilter,$typeUseFilter, $cityFilter, $districtFilter, $projectFilter,$dailyFilter);
        // Retrieve the gallery associated with the broker
        $gallery = $this->galleryService->findByBrokerId($brokerId);
        $galleries = $this->galleryService->all();
        $districts = $this->galleryService->findById($gallery->id)->BrokerData->BrokerHasUnits;
        $districtsIds = $districts->pluck('district_id')->toArray();
        $numberOfVisitorsForEachUnit = [];
        foreach ($units as $unit) {
            $numberOfVisitorsForEachUnit[$unit->id] = $unit->visitors()->count();
        }


        return view('Broker.Gallary.index', get_defined_vars());
    }



    public function showGallery($galleryId)
    {
        $gallery = $this->galleryService->findById($galleryId);
        return view('Broker.Gallery.show', compact('gallery'));
    }

    public function create(Request $request)
    {
        $data = $request->validated();
        $this->galleryService->create($data);
        return redirect()->route('gallery.index')->with('success', 'Gallery created successfully');
    }



    public function destroy($galleryId)
    {
        $this->galleryService->delete($galleryId);
        return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully');
    }


    public function show(string $id)
    {
        //
        $Unit = $this->UnitService->findById($id);
        // $unitInterests = UnitInterest::where('unit_id', $id)->get();
        $brokerId = auth()->user()->UserBrokerData->id;
        $subscription = $this->subscriptionService->findSubscriptionByBrokerId($brokerId);
        if ($subscription) {
            $sectionsIds = auth()->user()
                ->UserBrokerData->UserSubscription->SubscriptionSectionData->pluck('section_id')
                ->toArray();
            if (in_array(18, $sectionsIds)) {
                $unitInterests = $this->unitInterestService->getUnitInterestsByUnitId($id);
                $interestsTypes = $this->settingService->getAllInterestTypes();
            }
        }

        return view('Broker.Gallary.show',  get_defined_vars());
    }





    public function showGalleryUnit($broker_name, $id)
    {
        $Unit = $this->UnitService->findById($id);
        return view('Broker.Gallery.show', get_defined_vars());
    }


    public function showInterests()
    {

        $gallery = $this->galleryService->findByBrokerId(auth()->user()->UserBrokerData->id) ?? null;
        $gallrays = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        $interests = $this->settingService->getAllInterestTypes();
        return view('Broker.Gallary.unit-interest', get_defined_vars());
    }



    public function showUnitPublic($gallery_name, $id)
    {

        $data = $this->galleryService->showUnitPublic($gallery_name, $id);
        if (empty($data) || (isset($data['gallery']) && $data['gallery']->gallery_status == 0)) {

            return view('Broker.Gallary.inc._GalleryComingsoon',$data);
        }


        $visitor = $this->visitorService->findVisitorByUnitAndIP($id, request()->ip());


            if (!$visitor) {
                $this->visitorService->createVisitor([
                    'unit_id' => $id,
                    'gallery_id' => $data['gallery']->id,
                    'ip_address' => request()->ip(),
                    'visited_at' => now(),
                ]);
            }
        $unitVisitorsCount = [];
        foreach ($data['units'] as $unit) {
            $unitVisitorsCount[$id] = $this->visitorService->getUnitVisitorCount($unit->id);
        }

        $data['unitVisitorsCount'] = $unitVisitorsCount;
        return view('Home.Gallery.Unit.show', $data);
    }

    public function showByName(Request $request, $name)
    {
        $cityFilter = $request->input('city_filter', 'all');
        $propertyTypeFilter = $request->input('property_type_filter', 'all');
        $projectFilter = $request->input('project_filter', 'all');
        $typeUseFilter = $request->input('type_use_filter', 'all');
        $adTypeFilter = request()->input('ad_type_filter', 'all');
        $priceFrom = $request->input('price_from', null);
        $priceTo = $request->input('price_to', null);
        $hasImageFilter = $request->input('has_image_filter', false);
        $hasPriceFilter = $request->input('has_price_filter', false);
        $daily_rent = $request->input('daily_rent', false);
        $districtFilter = request()->input('district_filter', 'all');


        $data = $this->galleryService->showByName($name, $cityFilter,$propertyTypeFilter,$districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent);
        if (empty($data) || (isset($data['gallery']) && $data['gallery']->gallery_status == 0)) {
            return view('Broker.Gallary.inc._GalleryComingsoon', $data);
        }
        // $districts = Gallery::where('id', $data['gallery']->id)->first()->BrokerData->BrokerHasUnits; // رجع دي في الفيو
        // $visitor = Visitor::where('gallery_id', $data['gallery']->id)
        //     ->where('ip_address', $request->ip())
        //     ->where('visited_at', '>=', now()->subHour())
        //     ->first();
        $visitor = $this->visitorService->findVisitorByGalleryAndIP($data['gallery']->id, $request->ip());

        if (!$visitor) {
            $this->visitorService->createVisitor([
                'gallery_id' => $data['gallery']->id,
                'unit_id' => null,
                'ip_address' => $request->ip(),
                'visited_at' => now(),
            ]);
        }

        $unitVisitorsCount = [];
        foreach ($data['units'] as $unit) {
            $unitVisitorsCount[$unit->id] = $this->visitorService->getUnitVisitorCount($unit->id);
        }

        $data['unitVisitorsCount'] = $unitVisitorsCount;
        return view('Home.Gallery.index', $data);
    }


    public function update(Request $request, $galleryId)
    {

        $this->galleryService->update($request->all(), $galleryId);

        return redirect()->back()->with('success', 'Gallery updated successfully');
    }

    public function updateCover(Request $request)
    {
        $this->galleryService->updateCover($request->all());

        return back()->withSuccess(__('Updated successfully.'));
    }

    public function createGallery(Request $request)
    {
        $request->validate([
            'gallery_name' => 'required|string|max:255',
        ]);
        $galleryName = $request->input('gallery_name');
        $user = auth()->user();
        if ($user->is_broker) {
            $gallery = $this->galleryService->create([
                'gallery_name' => $galleryName,
                'broker_id' => auth()->user()->UserBrokerData->id,
                'gallery_cover' => '/Gallery/cover/cover.png',
                'gallery_status' => 1,
            ]);
        } elseif ($user->is_office) {
            $gallery = $this->galleryService->create([
                'gallery_name' => $galleryName,
                'office_id' => auth()->user()->UserOfficeData->id,
                'gallery_cover' => '/Gallery/cover/cover.png',
                'gallery_status' => 1,
            ]);
        } else {
            return redirect()->back()->withError('User is neither a broker nor an office.');
        }

        return redirect()->route('Broker.Gallery.index')->withSuccess('Gallery created successfully.');
    }





    public function downloadQrCode($link)
    {
        $qrCode = QrCode::size(200)->generate($link);
        $dataUri = 'data:image/jpg;base64,' . base64_encode($qrCode);

        $headers = [
            'Content-Type' => 'image/jpg',
            'Content-Disposition' => 'attachment; filename="qrcode.jpg"',
        ];

        return response()->stream(function () use ($dataUri) {
            echo file_get_contents($dataUri);
        }, 200, $headers);
    }


    function GetDistrictByCity($id)
    {
        $districts = $this->districtService->getDistrictsByCity($id);
        $districtsIds = $this->UnitService->getAll(auth()->user()->UserBrokerData->id)->pluck('district_id')->toArray();
        return view('Broker.Gallary.inc._district', get_defined_vars());
    }

    public function showAllGalleries(Request $request)
    {
        $cityFilter = $request->input('city_filter', 'all');
        $propertyTypeFilter = $request->input('property_type_filter', 'all');
        $projectFilter = $request->input('project_filter', 'all');
        $typeUseFilter = $request->input('type_use_filter', 'all');
        $adTypeFilter = request()->input('ad_type_filter', 'all');
        $priceFrom = $request->input('price_from', null);
        $priceTo = $request->input('price_to', null);
        $hasImageFilter = $request->input('has_image_filter', false);
        $hasPriceFilter = $request->input('has_price_filter', false);
        $daily_rent = $request->input('daily_rent', false);
        $districtFilter = request()->input('district_filter', 'all');


        $data = $this->galleryService->showAllGalleries($cityFilter,$propertyTypeFilter,$districtFilter, $projectFilter,$typeUseFilter,$adTypeFilter,$priceFrom , $priceTo ,$hasImageFilter , $hasPriceFilter,$daily_rent);
        return view('Home.Gallery.indexAll',  $data);
    }


}
