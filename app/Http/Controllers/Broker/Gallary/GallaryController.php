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


    public function __construct(GalleryService $galleryService,UnitService $UnitService,  RegionService $regionService,DistrictService $districtService, AllServiceService $AllServiceService, FeatureService $FeatureService, CityService $cityService, BrokerDataService $brokerDataService, PropertyTypeService $propertyTypeService, ServiceTypeService $ServiceTypeService, PropertyUsageService $propertyUsageService){
        $this->galleryService = $galleryService;

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

    }
    public function index()
    {

        //
        $ad_type_filter = 'all';
        $type_use_filter = 'all';
        $city_filter = null;

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

        //filters
        $units = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);

        if (request()->has('ad_type_filter')) {
            $ad_type_filter = request('ad_type_filter');
            $units = $units->where('type', $ad_type_filter);
        }

        if (request()->has('type_use_filter')) {
            $type_use_filter = request('type_use_filter');
            $units = $units->where('type_use', $type_use_filter);
        }

        if (request()->has('city_filter')) {
            $city_filter = request('city_filter');
            $units = $units->where('city_id', $city_filter);
        }
        //
        $brokerId = auth()->user()->UserBrokerData->id;
        $gallery = $this->galleryService->findByBrokerId($brokerId);

       $galleries = $this->galleryService->all();

        return view('Broker.Gallary.index',get_defined_vars());
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



    public function update(Request $request, $gallery)
    {
        $request->validate([
            'gallery_name' => 'required|string|max:255',
            'gallery_status' => 'nullable|in:0,1',
        ]);

        $gallery = Gallery::findOrFail($gallery);


        $gallery->update([
            'gallery_name' => $request->gallery_name,
            'gallery_status' => $request->has('gallery_status') ? '1' : '0',
        ]);

        return redirect()->back()->with('success', 'Gallery updated successfully');
    }

    public function updateCover(Request $request)
    {
        $request->validate([
            'gallery_cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gallery = Gallery::findOrFail($request->gallery_id);

        if ($request->hasFile('gallery_cover')) {
            $file = $request->file('gallery_cover');
            $ext = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Gallery/cover/'), $ext);
            $gallery->update(['gallery_cover' => 'Gallery/cover/' . $ext]);
        }

        return back()->withSuccess(__('Updated successfully.'));
    }





    public function showGalleryUnit($broker_name, $id)
    {
        $Unit = $this->UnitService->findById($id);
        return view('Broker.Gallery.show', get_defined_vars());
    }


    public function showInterests()
    {
        $gallrays = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        return view('Broker.Gallary.unit-interest',get_defined_vars());
    }

    public function showByName($name)
    {

        $gallery = Gallery::where('gallery_name', $name)->firstOrFail();
        if ($gallery->gallery_status == 0) {
            abort(404);
        }
        $units = $this->UnitService->getAll($gallery['broker_id']);

        $unit = $units->first();

        $id = $unit->id;

        $unitDetails = $this->UnitService->findById($id);


        return view('Home.Gallery.index', get_defined_vars());
    }

    public function showUnitPublic($gallery_name, $id)
    {
        $gallery = Gallery::where('gallery_name', $gallery_name)->first();
        if ($gallery->gallery_status == 0) {
            abort(404);
        }
        $units = $this->UnitService->getAll($gallery['broker_id']);
        $Unit = $this->UnitService->findById($id);

        $unit = Unit::findOrFail($id);

        $id = $unit->id;

        if (!$gallery || !$unit) {
            abort(404);
        }

        return view('Home.Gallery.Unit.show', get_defined_vars());
    }



    public function update1(Request $request, $galleryId)
    {
        $data = $request->validated();

        $this->galleryService->update($data, $galleryId);

        return redirect()->back()->with('success', 'Gallery updated successfully');
    }

    public function updateCover1(Request $request)
    {
        $data = $request->validated();

        $this->galleryService->updateCover($data);

        return back()->withSuccess(__('Updated successfully.'));
    }

}
