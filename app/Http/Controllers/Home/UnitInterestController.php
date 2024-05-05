<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\InterestType;
use App\Models\InterestTypeTranslation;
use App\Models\PropertyUsage;
use App\Models\Unit;
use App\Models\UnitInterest;
use App\Models\User;
use App\Notifications\Admin\NewIntrestOrderNotification;
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
use App\Services\Broker\UnitInterestService;
use Illuminate\Support\Facades\Notification;

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
    protected $unitInterestService;



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
        UnitInterestService $unitInterestService
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

    }


    public function index(Request $request)
    {

        $interestsTypes = $this->settingService->getAllInterestTypes();
        $statusFilter = $request->input('status_filter', 'all');
        $propFilter = $request->input('prop_filter', 'all');
        $unitFilter = $request->input('unit_filter', 'all');
        $projectFilter = $request->input('prj_filter', 'all');
        $clientFilter = $request->input('client_filter', 'all');
        $unitInterests =$this->unitInterestService->index($request);

        return view('Broker.Gallary.unit-interest', get_defined_vars());
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

        $intrestOrder= $this->unitInterestService->store($request);

        $this->notifyAdmins($intrestOrder);


        return redirect()->back()->with('success', 'Unit Interest created successfully.');
    }


    protected function notifyAdmins(UnitInterest $intrestOrder)
    {
        $borkers = User::where('is_broker', true)->get();
        foreach ($borkers as $borker) {
            Notification::send($borker, new NewIntrestOrderNotification($intrestOrder));
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
        $unitInterest = $this->unitInterestService->find($id);

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


}
