<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use App\Services\RegionService;
use App\Services\CityService;

class SettingController extends Controller
{

    protected $regionService;
    protected $cityService;

    public function __construct( RegionService $regionService, CityService $cityService)
    {

        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }
    public function index()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $subscriptionTypes = SubscriptionType::whereHas('Roles', function ($query) {
            $query->where('name', 'RS-Broker');
        })->get();
        return view('Broker.settings.index',get_defined_vars());

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
}
