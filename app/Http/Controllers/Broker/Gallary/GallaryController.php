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
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Broker\GalleryService;
use App\Services\Admin\SettingService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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




    public function __construct(SettingService $settingService,
    GalleryService $galleryService,UnitService $UnitService,  RegionService $regionService,DistrictService $districtService, AllServiceService $AllServiceService, FeatureService $FeatureService, CityService $cityService, BrokerDataService $brokerDataService, PropertyTypeService $propertyTypeService, ServiceTypeService $ServiceTypeService, PropertyUsageService $propertyUsageService)
    {
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
        $unitsWithDistricts = $units->filter(function ($unit) {
            return $unit->CityData->DistrictsCity->isNotEmpty();
        });

        $uniqueDistrictIds = $unitsWithDistricts->pluck('CityData.DistrictsCity.*.id')->flatten()->unique();
        $uniqueDistrictNames = $unitsWithDistricts->pluck('CityData.DistrictsCity.*.name')->flatten()->unique();


        // Filter units based on request parameters
        $adTypeFilter = request()->input('ad_type_filter', 'all');
        $typeUseFilter = request()->input('type_use_filter', 'all');
        $cityFilter = request()->input('city_filter', 'all');
        $districtFilter = request()->input('district_filter', 'all');
        $projectFilter = request()->input('project_filter', 'all');
        $units = $this->galleryService->filterUnits($units, $adTypeFilter, $typeUseFilter, $cityFilter, $districtFilter);
        // Retrieve the gallery associated with the broker
        $gallery = $this->galleryService->findByBrokerId($brokerId);
        $galleries = $this->galleryService->all();

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
        $interests =$this->settingService->getAllInterestTypes();
        return view('Broker.Gallary.unit-interest',get_defined_vars());

    }



    public function showUnitPublic($gallery_name, $id)
        {

            $data = $this->galleryService->showUnitPublic($gallery_name, $id);
            if (empty($data)) {
                return view('Broker.Gallary.inc._GalleryComingsoon',get_defined_vars());
            }
            return view('Home.Gallery.Unit.show', $data);
        }

        public function showByName(Request $request, $name)
        {


            $cityFilter = $request->input('city_filter', 'all');
            $projectFilter = $request->input('project_filter', 'all');
            $typeUseFilter = $request->input('type_use_filter', 'all');
            $adTypeFilter = request()->input('ad_type_filter', 'all');
            $priceFrom = $request->input('price_from',null);
            $priceTo = $request->input('price_to',null);

            // Call the showByName() method with all required arguments
            $data = $this->galleryService->showByName($name, $cityFilter, $projectFilter,$typeUseFilter,$adTypeFilter,$priceFrom , $priceTo);
            // dd($data);
                if (empty($data)) {
                    return view('Broker.Gallary.inc._GalleryComingsoon', get_defined_vars());
                }
                return view('Home.Gallery.index',$data);
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
        $dataUri = 'data:image/png;base64,' . base64_encode($qrCode);

        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qrcode.png"',
        ];

        return response()->stream(function () use ($dataUri) {
            echo file_get_contents($dataUri);
        }, 200, $headers);
    }



}


