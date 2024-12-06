<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\Gallery;
use App\Models\NotificationSetting;
use App\Models\Office;
use App\Models\Subscription;
use App\Services\Admin\EmailSettingService;
use Illuminate\Http\Request;
use App\Services\RegionService;
use App\Services\CityService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\Broker\UnitService;
use App\Services\Broker\SettingService;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;





class SettingController extends Controller
{
    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $EmailSettingService;
    protected $settingService;
    protected $subscriptionService;
    protected $SubscriptionTypeService;


    public function __construct(
        SubscriptionService $subscriptionService,
        SettingService $settingService,
        UnitService $UnitService,
        RegionService $regionService,
        CityService $cityService,
        EmailSettingService $EmailSettingService,
        SubscriptionTypeService $SubscriptionTypeService
    ) {
        $this->UnitService = $UnitService;
        $this->regionService = $regionService;
        $this->EmailSettingService = $EmailSettingService;
        $this->cityService = $cityService;
        $this->settingService = $settingService;
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;

        $this->middleware(['role_or_permission:read-building'])->only(['index']);
    }
    public function index()
    {

        $EmailSettingService = $this->EmailSettingService->getAll();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $broker = auth()->user()->UserBrokerData;
        $settings = $this->settingService->getBrokerSettings($broker);
        $city = $broker->CityData;
        $region = $city->RegionData;
        $gallery = $settings['gallery'];
        $NotificationSetting = $settings['notificationSettings'];
        $subscriber = $this->subscriptionService->findSubscriptionByBrokerId(auth()->user()->UserBrokerData->id);
        $sectionNames = [];
        if ($subscriber) {
            $subscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($subscriber->subscription_type_id);
            $hasRealEstateGallerySection = $subscriptionType->sections()->get();
            $sectionNames = $hasRealEstateGallerySection->pluck('name')->toArray();
        }

        $UserSubscriptionTypes = $this->SubscriptionTypeService->getGallerySubscriptionTypes();
        // return Auth::user()->UserBrokerData->UserSubscription->subscription_type_id;
        return view('Broker.settings.index', get_defined_vars());
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
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateBroker(Request $request, $id)
    {

        $data = $request->all();
        $this->settingService->updateBroker($data, $id);
        return redirect()->route('Broker.Setting.index')->withSuccess(__('Updated successfully.'));
    }
}
