<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\PropertyUsage;
use App\Models\Unit;
use App\Models\UnitInterest;
use Illuminate\Http\Request;
use App\Services\Admin\SettingService;
use App\Services\Broker\UnitService;
use App\Services\RegionService;
use App\Services\CityService;
use App\Services\AllServiceService;
use App\Services\Broker\BrokerDataService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\ServiceTypeService;
use App\Services\Broker\GalleryService;
use App\Services\Admin\DistrictService;




class UnitInterestController extends Controller
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


    public function index(Request $request)
    {

        $interestsTypes =$this->settingService->getAllInterestTypes();
        $statusFilter = $request->input('status_filter', 'all');
        $propFilter = $request->input('prop_filter', 'all');
        $unitFilter = $request->input('unit_filter', 'all');
        $projectFilter = $request->input('prj_filter', 'all');
        $clientFilter = $request->input('client_filter', 'all');

        $userId = auth()->user()->UserBrokerData->user_id;
        $unitInterests = UnitInterest::with('unit', 'user')
            ->where('user_id', $userId)
            ->get();

            $unitInterests = $this->getFilteredUnitInterests(
                $userId,
                $statusFilter,
                $propFilter,
                $unitFilter,
                $projectFilter,
                $clientFilter
            );


        return view('Broker.Gallary.unit-interest',get_defined_vars());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'user_id' => 'required|exists:users,id',
        ]);


        $requestData = $request->all();
        $requestData['status'] = 'new order';

        UnitInterest::create($requestData);

        return redirect()->back()->with('success', 'Unit Interest created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unitInterest = UnitInterest::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'id' => 'required|exists:unit_interests,id',
            'status' => 'required',
        ]);


        // Find the unit interest by ID
        $unitInterest = UnitInterest::findOrFail($request->id);

        // Update the status
        $unitInterest->update(['status' => $request->status]);

        // Optionally, you can return a response or redirect
        return redirect()->back()->with('success', 'Status updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getFilteredUnitInterests($userId, $statusFilter, $propFilter, $unitFilter, $projectFilter, $clientFilter)
    {
        $query = UnitInterest::with('unit', 'user')->where('user_id', $userId);

        // Apply status filter
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Apply property filter
        if ($propFilter !== 'all') {
            $query->where('property_id', $propFilter);
        }

        // Apply unit filter
        if ($unitFilter !== 'all') {
            $query->where('unit_id', $unitFilter);
        }

        // Apply project filter
        if ($projectFilter !== 'all') {
            $query->whereHas('unit.PropertyData', function ($q) use ($projectFilter) {
                $q->where('project_id', $projectFilter);
            });
        }

        // Apply client filter
        if ($clientFilter !== 'all') {
            $query->where('id', $clientFilter);
        }

        return $query->get();
    }

}
