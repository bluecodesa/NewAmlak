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
use App\Services\Broker\ProjectService;
use App\Services\Broker\PropertyService;
use App\Services\Office\EmployeeService;
use App\Services\Broker\TicketService;
use App\Services\Office\ProjectService as OfficeProjectService;
use App\Services\Office\PropertyService as OfficePropertyService;

class SubscriptionController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $cityService;
    protected $ownerService;
    protected $UnitService;
    protected $PropertyService;
    protected $ProjectService;

    protected $systemInvoiceRepository;

    protected $EmployeeService;
    protected $ticketService;
    protected $OfficeProjectService;
    protected $OfficePropertyService;



    public function __construct(
        SystemInvoiceRepositoryInterface $systemInvoiceRepository,
        UnitService $UnitService,
        OwnerService $ownerService,
        SubscriptionService $subscriptionService,
        RegionService $regionService,
        CityService $cityService,
        EmployeeService $EmployeeService,
        TicketService $ticketService,
        PropertyService $PropertyService,
        OfficePropertyService $OfficePropertyService,
        ProjectService $ProjectService,

        OfficeProjectService $OfficeProjectService,


    ) {
        $this->subscriptionService = $subscriptionService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->ownerService = $ownerService;
        $this->UnitService = $UnitService;
        $this->systemInvoiceRepository = $systemInvoiceRepository;
        $this->EmployeeService = $EmployeeService;
        $this->ticketService = $ticketService;
        $this->PropertyService = $PropertyService;
        $this->ProjectService = $ProjectService;
        $this->OfficePropertyService = $OfficePropertyService;
        $this->OfficeProjectService = $OfficeProjectService;



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
        // $subscribers = $this->subscriptionService->getAllSubscribers();
        $subscribers = $this->subscriptionService->getAllUsers();
        // $clients = User::where('is_admin', 0)
        // ->where('is_broker', 0)
        // ->where('is_office', 0)
        // ->get();
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

    // public function show(string $id)
    // {

    //     $subscriber = $this->subscriptionService->findSubscriptionById($id);
    //     if (!$subscriber) {
    //         return redirect()->route('Admin.Subscribers.index')->with('error', 'This account is deleted.');
    //     }
    //     $brokerId = $subscriber->broker_id;
    //     $officeId = $subscriber->office_id;

    //     if ($brokerId) {
    //         $numberOfowners = $this->ownerService->getNumberOfOwners($brokerId);
    //         $numberOfUnits = $this->UnitService->getAll($brokerId)->count();
    //         $invoices = $this->systemInvoiceRepository->findByBrokerId($brokerId);
    //         $numberOfProperties = $this->UnitService->getAll($brokerId)->count();
    //         $numberOfProjects = $subscriber->BrokerData->BrokerHasProjects->count();
    //         return view('Admin.subscribers.ShowBroker', get_defined_vars());
    //     } elseif ($officeId) {
    //         $numberOfowners = $this->ownerService->getNumberOfOwners($officeId);
    //         $numberOfUnits = $this->UnitService->getAllByOffice($officeId)->count();
    //         $numberOfProjects = $this->UnitService->getAllByOffice($officeId)->count();
    //         $numberOfProperties = $this->UnitService->getAll($officeId)->count();
    //         $invoices = $this->systemInvoiceRepository->findByOfficeId($officeId);
    //         $employees = $this->EmployeeService->getAllByOfficeId($officeId);

    //         return view('Admin.subscribers.show', get_defined_vars());
    //     }
    // }

    public function show(string $id)
    {
        $subscriber = $this->subscriptionService->findUserById($id);

        if (!$subscriber) {
            return redirect()->route('Admin.Subscribers.index')->with('error', 'This account is deleted.');
        }

        $entityId = null;
        $numberOfowners = 0;
        $numberOfUnits = 0;
        $numberOfProjects = 0;
        $numberOfProperties = 0;
        $invoices = [];
        $employees = [];
        $residentialCount = 0;
        $nonResidentialCount = 0;
        $galleryItems = collect();

        // Get user type and set specific data
        if ($subscriber->is_broker) {
            $entity = $subscriber->UserBrokerData;
            $entityId = $entity->id;
            $numberOfProjects = $entity->BrokerHasProjects->count();
            $invoices = $this->systemInvoiceRepository->findByBrokerId($entityId);
            $numberOfowners = $this->ownerService->getNumberOfOwners($entityId);
            $numberOfUnits = $this->UnitService->getAll($entityId)->count();
            $numberOfProperties = $this->PropertyService->getAll($entityId)->count();
            $units = $this->UnitService->getAll($entityId)
            ->where('show_gallery',1)->where('ad_license_status','Valid');
            $properties = $this->PropertyService->getAll($entityId)
            ->where('show_in_gallery',1)->where('ad_license_status','Valid');
            $projects = $this->ProjectService->getAllProjectsByBrokerId($entityId)
            ->where('show_in_gallery',1)->where('ad_license_status','Valid');

            $galleryItems = $galleryItems->merge($units)
                                        ->merge($properties)
                                        ->merge($projects);

        } elseif ($subscriber->is_office) {
            $entity = $subscriber->UserOfficeData;
            $entityId = $entity->id;
            $invoices = $this->systemInvoiceRepository->findByOfficeId($entityId);
            $employees = $this->EmployeeService->getAllByOfficeId($entityId);
            $numberOfowners = $this->ownerService->getNumberOfOwners($entityId);
            $numberOfUnits = $this->UnitService->getAllByOffice($entityId)->count();
            $numberOfProjects = $this->UnitService->getAllByOffice($entityId)->count();
            $numberOfProperties = $this->UnitService->getAll($entityId)->count();
            $units = $this->UnitService->getAllByOffice($entityId)
            ->where('show_gallery',1)->where('ad_license_status','Valid');
            $properties = $this->OfficePropertyService->getAll($entityId)
            ->where('show_in_gallery',1)->where('ad_license_status','Valid');
            $projects = $this->OfficeProjectService->getAllProjectsByOfficeId($entityId)
            ->where('show_in_gallery',1)->where('ad_license_status','Valid');

            $galleryItems = $galleryItems->merge($units)
                                        ->merge($properties)
                                        ->merge($projects);

        } elseif ($subscriber->is_owner) {
            $entity = $subscriber->UserOwnerData;
            $entityId = $entity->id;
            $invoices = $this->systemInvoiceRepository->findByOfficeId($entityId);
            $employees = $this->EmployeeService->getAllByOfficeId($entityId);
            $numberOfowners = $this->ownerService->getNumberOfOwners($entityId);
            $numberOfUnits = $this->UnitService->getAllByOffice($entityId)->count();
            $numberOfProjects = $this->UnitService->getAllByOffice($entityId)->count();
            $numberOfProperties = $this->UnitService->getAll($entityId)->count();
            
        }

        // Fetch residential and non-residential counts
        $tickets = $this->ticketService->getUserTickets($subscriber->id);
        $residentialCount = $this->getPropertyCountByType($entityId, $subscriber, 'Residential');
        $nonResidentialCount = $this->getPropertyCountByType($entityId, $subscriber, 'Non-Residential');

        return view('Admin.subscribers.show', get_defined_vars());
    }

    /**
     * Get property count based on usage type (Residential or Non-Residential).
     */
    private function getPropertyCountByType($entityId, $subscriber, $type)
    {
        if ($type == 'Residential') {
            return Unit::where($this->getEntityKey($subscriber), $entityId)
                ->whereHas('PropertyUsageData.translations', function ($query) {
                    $query->where('name', 'Residential');
                })
                ->count();
        }

        return Unit::where($this->getEntityKey($subscriber), $entityId)
            ->whereDoesntHave('PropertyUsageData.translations', function ($query) {
                $query->where('name', 'Residential');
            })
            ->count();
    }

    /**
     * Get the entity key (broker_id, office_id, owner_id) based on subscriber type.
     */
    private function getEntityKey($subscriber)
    {
        if ($subscriber->is_broker) {
            return 'broker_id';
        } elseif ($subscriber->is_office) {
            return 'office_id';
        } elseif ($subscriber->is_owner) {
            return 'owner_id';
        }

        return null;
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
    public function showClient(string $id)
    {
        $client = User::where('is_admin', 0)
        ->where('is_broker', 0)
        ->where('is_office', 0)
        ->findOrFail($id);
        $client_id=$client->id;
        $numberOfowners = $this->ownerService->getNumberOfOwners($client_id);
        $numberOfUnits = $this->UnitService->getAllByOffice($client_id)->count();
        $numberOfProjects = $this->UnitService->getAllByOffice($client_id)->count();
        $numberOfProperties = $this->UnitService->getAll($client_id)->count();
        $invoices = $this->systemInvoiceRepository->findByOfficeId($client_id);
        $employees = $this->EmployeeService->getAllByOfficeId($client_id);

        return view('Admin.subscribers.Clients.show', get_defined_vars());
    }
}
