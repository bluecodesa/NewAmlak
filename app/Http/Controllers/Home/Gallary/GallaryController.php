<?php

namespace App\Http\Controllers\Home\Gallary;

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
use App\Models\Advertising;
use App\Models\Broker;
use App\Models\City;
use App\Models\District;
use App\Models\FalLicenseUser;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\TicketType;
use App\Models\Unit;
use App\Models\UnitInterest;
use App\Models\Visitor;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Broker\GalleryService;
use App\Services\Broker\ProjectService;
use App\Services\Broker\PropertyService;
use App\Services\Admin\SettingService;
use App\Services\Broker\UnitInterestService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Home\GalleryService as HomeGalleryService;
use Carbon\Carbon;

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
    protected $ProjectService;
    protected $PropertyService;



    public function __construct(
        SettingService $settingService,
        HomeGalleryService $galleryService,
        ProjectService $ProjectService,
        PropertyService $PropertyService,
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
        SubscriptionService $subscriptionService

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
        $this->ProjectService = $ProjectService;
        $this->PropertyService = $PropertyService;

    }


    protected function updateAdLicenseStatus($allItemsProperties)
    {
        foreach ($allItemsProperties as $item) {
            if (isset($item->ad_license_expiry) && $item->ad_license_expiry < now()->format('Y-m-d')) {
                $item->update(['ad_license_status' => 'InValid']);
            }
        }
    }


    public function showUnitPublic($gallery_name, $id)
    {
        $data = $this->galleryService->showUnitPublic($gallery_name, $id);
        // dd($data);
        if (empty($data) || (isset($data['gallery']) && $data['gallery']->gallery_status == 0)) {
            return view('Broker.Gallary.inc._GalleryComingsoon', $data);
        }
        if (empty($data) || (isset($data['Unit']) && $data['Unit']->show_in_gallery == 0)) {
            return view('Broker.Gallary.inc._GalleryComingsoon', $data);
        }

        $unit = $data['Unit'];
        $cityId = $unit->city_id;
        $propertyTypeId = $unit->property_type_id;
        $propertyUsageId = $unit->property_usage_id;


        //or type , orproperty type , orusage  , and sort by discrit
        $moreUnits = Unit::where('id', '!=', $id)
        ->where('ad_license_status', 'Valid')
        ->where(function($query) use ($cityId, $propertyTypeId, $propertyUsageId, $unit) {
            $query->where('city_id', $cityId)
                ->orWhere('property_type_id', $propertyTypeId)
                ->orWhere('property_usage_id', $propertyUsageId)
                ->orWhere('type', $unit->type);
        })
        ->paginate(3);

        $allUnits = Unit::where('show_in_gallery',1)->take(6)->paginate(20);
// dd($allUnits);
        $unitLatLong = $unit->lat_long;
        [$lat, $long] = explode(',', $unitLatLong);
        $all5kiloUnits = Unit::selectRaw("*, ( 6371 * acos( cos( radians(?) ) * cos( radians( SUBSTRING_INDEX(lat_long, ',', 1) ) )
        * cos( radians( SUBSTRING_INDEX(lat_long, ',', -1) ) - radians(?) )
        + sin( radians(?) ) * sin( radians( SUBSTRING_INDEX(lat_long, ',', 1) ) ) ) ) AS distance", [$lat, $long, $lat])
            ->having('distance', '<=', 5)
            ->where('ad_license_status', 'Valid')
            ->where('id', '!=', $id)
            ->get();

        $data['all5kiloUnits'] = $all5kiloUnits;

        $data['allUnits'] = $allUnits;

        $data['moreUnits'] = $moreUnits;

        $broker = $data['broker'] ?? null;
        $office = $data['office'] ?? null;
        $user_id = null;

        if ($broker) {
            $user_id = $broker->UserData->id;
        } elseif ($office) {
            $user_id = $office->UserData->id;
        }

        if ($user_id) {
            $falLicense = FalLicenseUser::where('user_id', $user_id)
                ->whereHas('falData', function ($query) {
                    $query->where('for_gallery', 1);
                })
                ->where('ad_license_status', 'valid')
                ->first();
            }

            $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;
            if ($falLicense->ad_license_status == 'valid') {
            $data['CheckUnitExist'] = UnitInterest::where(['interested_id' => Auth::id(), 'unit_id' => $id])->exists();
            // dd($data);
            return view('Home.Gallery.Unit.show', $data);
        } else {
            return view('Broker.Gallary.inc._GalleryComingsoon', $data);
        }
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


        $data = $this->galleryService->showByName($name, $cityFilter, $propertyTypeFilter, $districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent);

        if (empty($data) || (isset($data['gallery']) && $data['gallery']->gallery_status == 0)) {
            return view('Broker.Gallary.inc._GalleryComingsoon', $data);
        }
        // $districts = Gallery::where('id', $data['gallery']->id)->first()->BrokerData->BrokerHasUnits; // رجع دي في الفيو
        $visitor = Visitor::where('gallery_id', $data['gallery']->id)
            ->where('ip_address', $request->ip())
            ->where('visited_at', '>=', now()->subHour())
            ->first();

        if (!$visitor) {
            $newVisitor = new Visitor();
            $newVisitor->gallery_id = $data['gallery']->id;
            $newVisitor->unit_id = null;
            $newVisitor->ip_address = $request->ip();
            $newVisitor->visited_at = now();
            $newVisitor->save();
        }

        $unitVisitorsCount = [];

        $sevenDaysAgo = Carbon::now()->subDays(7);
        foreach ($data['allItems'] as $unit) {
            if ($unit->isGalleryProject) {
                $unitVisitorsCount[$unit->id] = Visitor::where('project_id', $unit->id)
                    ->whereBetween('visited_at', [$sevenDaysAgo, Carbon::now()])
                    ->distinct('ip_address')
                    ->count('ip_address');
            } elseif ($unit->isGalleryProperty) {
                $unitVisitorsCount[$unit->id] = Visitor::where('property_id', $unit->id)
                    ->whereBetween('visited_at', [$sevenDaysAgo, Carbon::now()])
                    ->distinct('ip_address')
                    ->count('ip_address');
            } else {
                $unitVisitorsCount[$unit->id] = Visitor::where('unit_id', $unit->id)
                    ->whereBetween('visited_at', [$sevenDaysAgo, Carbon::now()])
                    ->distinct('ip_address')
                    ->count('ip_address');
            }
        }
        $data['unitVisitorsCount'] = $unitVisitorsCount;
        $advertisings = Advertising::where('status', 'Published')->get();

        $data['advertisings'] = $advertisings;

        // $check_val =  Gallery::where('id', $data['gallery']->id)->first()->BrokerData;
        // $user_id =  Gallery::where('id', $data['gallery']->id)->first()->BrokerData->UserData->id;
        $gallery = Gallery::where('id', $data['gallery']->id)->first();

        $user_id = $gallery->BrokerData?->UserData?->id
            ?? $gallery->OfficeData?->UserData?->id
            ?? null;

        $falLicense = FalLicenseUser::where('user_id', $user_id)
                    ->whereHas('falData', function ($query) {
                        $query->where('for_gallery', 1);
                    })
                    ->where('ad_license_status', 'valid')
                    ->first();
        $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;

        if ($falLicense) {
            if ($falLicense->ad_license_status == 'valid') {
                return view('Home.Gallery.index', $data);
            }
        }
        else {
            return view('Broker.Gallary.inc._GalleryComingsoon', $data);
        }
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
        $sortOrder = $request->input('sort_order', 'newest');

        $data = $this->galleryService->showAllGalleries($cityFilter, $propertyTypeFilter,
         $districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter,
         $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent,$sortOrder);

        foreach ($data['galleries'] as $gallery) {
            $visitor = Visitor::where('gallery_id', $gallery->id)
                ->where('ip_address', $request->ip())
                ->where('visited_at', '>=', now()->subHour())
                ->first();

            if (!$visitor) {
                $newVisitor = new Visitor();
                $newVisitor->gallery_id = $gallery->id;
                $newVisitor->unit_id = null;
                $newVisitor->ip_address = $request->ip();
                $newVisitor->visited_at = now();
                $newVisitor->save();
            }
        }

        $unitVisitorsCount = [];

        $sevenDaysAgo = Carbon::now()->subDays(7);
        foreach ($data['allItems'] as $unit) {
            if ($unit->isGalleryProject) {
                $unitVisitorsCount[$unit->id] = Visitor::where('project_id', $unit->id)
                    ->whereBetween('visited_at', [$sevenDaysAgo, Carbon::now()])
                    ->distinct('ip_address')
                    ->count('ip_address');
            } elseif ($unit->isGalleryProperty) {
                $unitVisitorsCount[$unit->id] = Visitor::where('property_id', $unit->id)
                    ->whereBetween('visited_at', [$sevenDaysAgo, Carbon::now()])
                    ->distinct('ip_address')
                    ->count('ip_address');
            } else {
                $unitVisitorsCount[$unit->id] = Visitor::where('unit_id', $unit->id)
                    ->whereBetween('visited_at', [$sevenDaysAgo, Carbon::now()])
                    ->distinct('ip_address')
                    ->count('ip_address');
            }
        }

        $advertisings = Advertising::where('status', 'Published')->get();

        $data['unitVisitorsCount'] = $unitVisitorsCount;
        $data['advertisings'] = $advertisings;

        $checkActive = Setting::first();
        if ($checkActive->active_gallery == 1) {
            return view('Home.Gallery.indexAll',  $data);
        } else {
            return view('Home.Gallery.ComingSoon');
        }
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

    public function showPubllicProperty($gallery_name, $id)
    {
        $property = $this->galleryService->ShowPublicProperty($id);
        if($property->BrokerData){
            $user_id=$property->BrokerData->UserData->id;
            $gallery_status=$property->BrokerData->GalleryData->gallery_status;

        }elseif($property->OfficeData){
            $user_id=$property->OfficeData->UserData->id;
            $gallery_status=$property->OfficeData->GalleryData->gallery_status;
        }
        $falLicense = FalLicenseUser::where('user_id', $user_id)
        ->whereHas('falData', function ($query) {
            $query->where('for_gallery', 1);
        })
        ->where('ad_license_status', 'valid')
        ->first();
        $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;
        if(!empty($property) && $falLicense->ad_license_status == 'valid' && $gallery_status != 0 ){
            $ticketTypes =  TicketType::paginate(100);

            $sevenDaysAgo = Carbon::now()->subDays(7);
            $propertyVisitorsCount = Visitor::where('property_id', $property->id)
            ->whereBetween('visited_at', [$sevenDaysAgo, Carbon::now()])
            ->distinct('ip_address')
            ->count('ip_address');

            $cityId = $property->city_id;
            $propertyTypeId = $property->property_type_id;
            $moreProperties = Property::where('id', '!=', $id)
            ->where('ad_license_status', 'Valid')
            ->where(function($query) use ($cityId, $propertyTypeId, $property) {
                $query->where('city_id', $cityId)
                      ->orWhere('property_type_id', $propertyTypeId)
                      ->orWhere('type', $property->type);
            })
            ->paginate(3);

            $allProperties = Property::where('ad_license_status','valid')->where('show_in_gallery',1)->take(6)->paginate(20);
            $propertyLatLong = $property->lat_long;

            [$lat, $long] = explode(',', $propertyLatLong);
            $all5kiloProperties = Property::selectRaw("*, ( 6371 * acos( cos( radians(?) ) * cos( radians( SUBSTRING_INDEX(lat_long, ',', 1) ) )
            * cos( radians( SUBSTRING_INDEX(lat_long, ',', -1) ) - radians(?) )
            + sin( radians(?) ) * sin( radians( SUBSTRING_INDEX(lat_long, ',', 1) ) ) ) ) AS distance", [$lat, $long, $lat])
                ->having('distance', '<=', 5)
                ->where('ad_license_status', 'Valid')
                ->where('id', '!=', $id)
                ->paginate(3);




            return view('Home.Gallery.Property.show',  get_defined_vars());
        }
        else {
            $property = Property::findOrFail($id);
            if($property->BrokerData){
                $broker=$property->BrokerData;

            }elseif($property->OfficeData){
                $office=$property->OfficeData;

            }
            return view('Broker.Gallary.inc._GalleryComingsoon', get_defined_vars());
        }


    }

    public function showPubllicProject($gallery_name, $id)
    {
        $project = $this->galleryService->ShowPublicProject($id);
        if(!empty($project)){
            if($project->BrokerData){
                $user_id=$project->BrokerData->UserData->id;
                $gallery_status=$project->BrokerData->GalleryData->gallery_status;

            }elseif($project->OfficeData){
                $user_id=$project->OfficeData->UserData->id;
                $gallery_status=$project->OfficeData->GalleryData->gallery_status;
            }
            // $user_id=$project->BrokerData->UserData->id;
            $falLicense = FalLicenseUser::where('user_id', $user_id)
            ->whereHas('falData', function ($query) {
                $query->where('for_gallery', 1);
            })
            ->where('ad_license_status', 'valid')
            ->first();
            $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;
            if(!empty($project) && $falLicense->ad_license_status == 'valid' && $gallery_status != 0 ){
                $ticketTypes =  TicketType::paginate(100);

                $cityId = $project->city_id;
                $districtId  = $project->district_id  ;
                $moreProjects = Project::where('id', '!=', $id)
                ->where('ad_license_status', 'Valid')
                ->where(function($query) use ($cityId, $districtId, $project) {
                    $query->where('city_id', $cityId)
                          ->orWhere('district_id', $districtId);
                })
                ->paginate(3);

                $allProjects = Project::take(6)->paginate(20);

                $projectLatLong = $project->lat_long;

                [$lat, $long] = explode(',', $projectLatLong);
                $all5kiloProjects  = Project::selectRaw("*, ( 6371 * acos( cos( radians(?) ) * cos( radians( SUBSTRING_INDEX(lat_long, ',', 1) ) )
                * cos( radians( SUBSTRING_INDEX(lat_long, ',', -1) ) - radians(?) )
                + sin( radians(?) ) * sin( radians( SUBSTRING_INDEX(lat_long, ',', 1) ) ) ) ) AS distance", [$lat, $long, $lat])
                    ->having('distance', '<=', 5)
                    ->where('ad_license_status', 'Valid')
                    ->where('id', '!=', $id)
                    ->paginate(3);



                return view('Home.Projects.show',  get_defined_vars());

            }
        } else {
            $project = Project::findOrFail($id);
            if($project->BrokerData){
                $broker=$project->BrokerData;
                $user=$broker->UserData;
                $gallery=$project->BrokerData->GalleryData;


            }elseif($project->OfficeData){
                $office=$project->OfficeData;
                $user=$office->UserData;
                $gallery=$project->OfficeData->GalleryData;

            }
            return view('Broker.Gallary.inc._GalleryComingsoon', get_defined_vars());
        }


    }



    function GetDistrictByCity($id)
    {
        $districts = $this->districtService->getDistrictsByCity($id);
        return view('Admin.settings.Region.inc._district', get_defined_vars());
    }

    public function saveHomeWorkDetails(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'propertyId' => 'required|integer',
            'details' => 'required|string',
        ]);

        // Store the details in the session
        session([
            'home_work_details' => [
                'propertyId' => $validatedData['propertyId'],
                'details' => $validatedData['details'],
            ],
        ]);

        // Optionally return a success response
        return response()->json(['message' => 'Details saved successfully in session!'], 200);
    }
    // Controller Method to Retrieve Home/Work Location
        public function getHomeWorkLocation()
        {
            $location = session('home_work_location', null);

            if ($location) {
                return response()->json(['homeWorkCoordinates' => $location]);
            }

            return response()->json(['error' => 'Location not found'], 404);
        }



}
