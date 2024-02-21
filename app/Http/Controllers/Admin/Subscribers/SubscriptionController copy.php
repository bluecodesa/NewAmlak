<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Http\Controllers\Controller;
use App\Services\Admin\SubscriptionService;
use Illuminate\Http\Request;
use App\Services\RegionService;
use App\Services\CityService;

class SubscriptionController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $cityService;

    public function __construct(SubscriptionService $subscriptionService, RegionService $regionService, CityService $cityService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $subscribers = $this->subscriptionService->getAllSubscribers();
        return view('Admin.subscribers.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $data = $this->subscriptionService->createOfficeSubscription($request->all());
        return view('Admin.admin.subscriptions.create', get_defined_vars());

    }

    public function store(Request $request)
    {
        // Implement store method logic if needed
    }

    public function show($id)
    {
        $subscriber = $this->subscriptionService->findSubscriptionById($id);
        return view('Admin.subscribers.show', compact('subscriber'));
    }

    public function edit($id)
    {
        // Implement edit method logic if needed
    }

    public function update(Request $request, $id)
    {
        // Implement update method logic if needed
    }

    public function destroy($id)
    {
        $this->subscriptionService->deleteSubscription($id);
        return redirect()->route('Admin.subscribers.index')->with('success', 'Subscriber deleted successfully');
    }

    public function suspendSubscription(Request $request, $id)
    {
        // Implement suspendSubscription method logic if needed
    }

    // Other methods as needed
}
