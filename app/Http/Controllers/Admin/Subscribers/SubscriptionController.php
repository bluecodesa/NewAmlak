<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\City;
use App\Models\Office;
use App\Models\Owner;
use App\Models\Region;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\SubscriptionTypeRole;
use App\Models\SystemInvoice;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\Admin\NewOfficeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Admin\SubscriptionService;
use App\Services\RegionService;
use App\Services\CityService;
use App\Services\OwnerService;

class SubscriptionController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $cityService;
    protected $ownerService;

    public function __construct(OwnerService $ownerService,SubscriptionService $subscriptionService, RegionService $regionService, CityService $cityService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->ownerService = $ownerService ;
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
        $subscriptionTypes = SubscriptionType::where('is_deleted', 0)
            ->whereHas('Roles', function ($query) {
                $query->where('name', 'Office-Admin');
            })
            ->get();

        return view('Admin.admin.Subscriptions.create', get_defined_vars());
    }



    public function store(Request $request)
    {
        $this->subscriptionService->createOfficeSubscription($request->all());

        return redirect()->route('Admin.Subscribers.index')->withSuccess(__('added successfully'));
    }



    public function show(string $id)
{
    $subscriber = $this->subscriptionService->findSubscriptionById($id);
    $brokerId = $subscriber->broker_id;
    $officeId = $subscriber->office_id;

    if ($brokerId) {
        $numberOfowners = $this->ownerService->getNumberOfOwners($brokerId);
        $numberOfUnits = Unit::where('broker_id', $brokerId)->count();
    } elseif ($officeId) {
        $numberOfowners = $this->ownerService->getNumberOfOwners($officeId);
        $numberOfUnits = Unit::where('office_id', $officeId)->count();
    }

    return view('Admin.subscribers.show', get_defined_vars());
}



    public function suspendSubscription(Request $request, $id)
    {
        $isSuspend = $request->input('is_suspend', 0);
        $this->subscriptionService->suspendSubscription($id, $isSuspend);

        if ($isSuspend == 0) {
            return redirect()->route('Admin.Subscribers.index')
                ->withSuccess(__('Subscription has been activated'));
        } else {
            return redirect()->route('Admin.Subscribers.index')
                ->withSuccess(__('Subscription has been suspended'));
        }
    }

    public function edit($id)
    {
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy($id)
    {
        $this->subscriptionService->deleteSubscription($id);
        return redirect()->route('Admin.Subscribers.index')->with('success', __('Deleted successfully'));
    }


    public function createBroker()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $subscriptionTypes = SubscriptionType::where('is_deleted', 0)
            ->whereHas('Roles', function ($query) {
                $query->where('name', 'RS-Broker');
            })
            ->get();

        return view('Admin.admin.Subscriptions.create_broker', get_defined_vars());
    }


    public function storeBroker(Request $request)
    {
        $this->subscriptionService->createBrokerSubscription($request->all());

        return redirect()->route('Admin.Subscribers.index')->withSuccess(__('Broker created successfully.'));
    }


    public function viewPending()
    {
        $pendingPayment = false;
        return view('Home.Payments.pending_payment', get_defined_vars());
    }
}
