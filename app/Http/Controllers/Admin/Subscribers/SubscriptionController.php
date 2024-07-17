<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Http\Controllers\Controller;
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
use App\Services\Broker\UnitService;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Models\Office;
use App\Services\Office\EmployeeService;


class SubscriptionController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $cityService;
    protected $ownerService;
    protected $UnitService;

    protected $systemInvoiceRepository;

    protected $EmployeeService;


    public function __construct(
        SystemInvoiceRepositoryInterface $systemInvoiceRepository,
        UnitService $UnitService,
        OwnerService $ownerService,
        SubscriptionService $subscriptionService,
        RegionService $regionService,
        CityService $cityService,
        EmployeeService $EmployeeService
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->ownerService = $ownerService;
        $this->UnitService = $UnitService;
        $this->systemInvoiceRepository = $systemInvoiceRepository;
        $this->EmployeeService = $EmployeeService;

        $this->middleware(['role_or_permission:read-subscribers'])->only('index');
        $this->middleware(['role_or_permission:read-subscriber-file'])->only('show');
        $this->middleware(['role_or_permission:create-subscriber'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:create-subscriber'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-subscriber'])->only(['destroy']);
    }

    public function index()
    {

        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $subscribers = $this->subscriptionService->getAllSubscribers();
        $clients = User::where('is_admin', 0)
        ->where('is_broker', 0)
        ->where('is_office', 0)
        ->get();
        return view('Admin.subscribers.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $subscriptionTypes = $this->subscriptionService->getSubscriptionTypesForOffice();
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
        if (!$subscriber) {
            return redirect()->route('Admin.Subscribers.index')->with('error', 'This account is deleted.');
        }
        $brokerId = $subscriber->broker_id;
        $officeId = $subscriber->office_id;

        if ($brokerId) {
            $numberOfowners = $this->ownerService->getNumberOfOwners($brokerId);
            $numberOfUnits = $this->UnitService->getAll($brokerId)->count();
            $invoices = $this->systemInvoiceRepository->findByBrokerId($brokerId);
            $numberOfProperties = $this->UnitService->getAll($brokerId)->count();
            $numberOfProjects = $subscriber->BrokerData->BrokerHasProjects->count();
            return view('Admin.subscribers.ShowBroker', get_defined_vars());
        } elseif ($officeId) {
            $numberOfowners = $this->ownerService->getNumberOfOwners($officeId);
            $numberOfUnits = $this->UnitService->getAllByOffice($officeId)->count();
            $numberOfProjects = $this->UnitService->getAllByOffice($officeId)->count();
            $numberOfProperties = $this->UnitService->getAll($officeId)->count();
            $invoices = $this->systemInvoiceRepository->findByOfficeId($officeId);
            $employees = $this->EmployeeService->getAllByOfficeId($officeId);

            return view('Admin.subscribers.show', get_defined_vars());
        }else{
            
            return view('Admin.subscribers.show', get_defined_vars());
        }
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

    public function deleteClient($id)
    {
        $authenticatedUser = auth()->user();
        $user =  User::findOrFail($id);

        if ($authenticatedUser->id === 1) {

            $user->syncRoles([]);
            $user->delete();

            return redirect()->route('Admin.Subscribers.index')->with('success', __('Deleted successfully'));
        }


        abort(403, 'You are not authorized to delete this user.');

    }


    public function createBroker()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $subscriptionTypes = $this->subscriptionService->getSubscriptionTypesForBroker();

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

    function LoginByUser($id)
    {
        auth()->loginUsingId($id);
        return redirect()->route('Admin.home');
    }

    public function updateNumOfEmployee(Request $request, string $id)
    {
        $request->validate([
            'max_of_employee' => 'required|numeric|min:1', // Add validation rules for max_of_employee field
        ], [
            'max_of_employee.required' => __('The max of employee field is required.'),
            'max_of_employee.numeric' => __('The max of employee field must be a number.'),
            'max_of_employee.min' => __('The max of employee field must be at least :min.'),
        ]);

        $office = Office::findOrFail($id);
        // Update the max_of_employee field
        $office->max_of_employee = $request->max_of_employee;
        $office->save();

        return redirect()->back()->with('success', __('Max number of employees updated successfully.'));
    }
}
