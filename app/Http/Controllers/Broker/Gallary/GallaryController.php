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
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Unit;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Broker\GalleryService;


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


    public function __construct(GalleryService $galleryService,UnitService $UnitService,  RegionService $regionService,DistrictService $districtService, AllServiceService $AllServiceService, FeatureService $FeatureService, CityService $cityService, BrokerDataService $brokerDataService, PropertyTypeService $propertyTypeService, ServiceTypeService $ServiceTypeService, PropertyUsageService $propertyUsageService)
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
        $units = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        //filters
        $adTypeFilter = request()->input('ad_type_filter', 'all');
        $typeUseFilter = request()->input('type_use_filter', 'all');
        $cityFilter = request()->input('city_filter');
        $units = $this->galleryService->filterUnits($units, $adTypeFilter, $typeUseFilter, $cityFilter);
        //
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
        return view('Broker.Gallary.unit-interest',get_defined_vars());



    }




        public function showUnitPublic($gallery_name, $id)
        {
            $data = $this->galleryService->showUnitPublic($gallery_name, $id);

            return view('Home.Gallery.Unit.show', $data);
        }

        public function showByName($name)
        {
            $data = $this->galleryService->showByName($name);

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

    public function customUpdate(Request $request, $galleryId)
{
    // Update the gallery status to 0 in the database
    $gallery = Gallery::findOrFail($galleryId);
    $gallery->update(['gallery_status' => 0]);

    // Optionally, you can redirect the user or return a response
    return redirect()->back()->with('success', 'Gallery status updated successfully.');
}




}


