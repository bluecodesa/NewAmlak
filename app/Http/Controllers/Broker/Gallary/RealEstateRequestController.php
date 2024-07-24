<?php

namespace App\Http\Controllers\Broker\Gallary;

use App\Http\Controllers\Controller;
use App\Models\RealEstateRequest;
use App\Models\RequestStatus;
use App\Services\RealEstateRequestService;
use Illuminate\Http\Request;
use App\Services\Admin\SettingService;
use App\Services\CityService;
use App\Services\PropertyTypeService;
use Illuminate\Support\Facades\Auth;

class RealEstateRequestController extends Controller
{

    protected $RealEstateRequestService;
    protected $settingService;
    protected $cityService;
    protected $propertyTypeService;



    public function __construct(RealEstateRequestService $RealEstateRequestService,
    SettingService $settingService,
    CityService $cityService,
    PropertyTypeService $propertyTypeService,

    )
    {
        $this->RealEstateRequestService = $RealEstateRequestService;
        $this->settingService = $settingService;
        $this->cityService = $cityService;
        $this->propertyTypeService = $propertyTypeService;




    }
    public function index()
    {
        $interestsTypes = $this->settingService->getAllInterestTypes();
        $cities = $this->cityService->getAllCities();
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $requests = $this->RealEstateRequestService->getAll();
        return view('Broker.Gallary.RealEstateRequests.index', get_defined_vars());

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $request = $this->RealEstateRequestService->getRequestById($id);
        $interestsTypes = $this->settingService->getAllInterestTypes();
        $requestStatus = RequestStatus::where('request_id', $id)
        ->where('user_id', Auth::id())
        ->first();

        return view('Broker.Gallary.RealEstateRequests.show', get_defined_vars());
    }

    public function updateInterestType(Request $request, $requestId)
    {
        $request->validate([
            'status' => 'required|exists:interest_types,id',
        ]);
    
        $requestStatus = RequestStatus::where('request_id', $requestId)
            ->where('user_id', Auth::id())
            ->first();
    
        if (!$requestStatus) {
            $requestStatus = new RequestStatus();
            $requestStatus->user_id = Auth::id();
            $requestStatus->request_id = $requestId;
        }
    
        $requestStatus->request_status_id = $request->input('status');
        $requestStatus->save();
    
        return redirect()->back()->with('success', 'Update successfully');
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,canceled',
        ]);

        $realEstateRequest = RealEstateRequest::findOrFail($id);
        $realEstateRequest->request_valid = $request->input('status');
        $realEstateRequest->save();

        return response()->json(['success' => true, 'status' => $realEstateRequest->request_valid]);
    }



}
