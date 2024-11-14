<?php

// app/Services/Admin/SystemInvoiceService.php

namespace App\Services\Admin;

use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\SystemInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\OfficeCreationService;
use App\Services\BrokerCreationService;
use App\Services\UserCreationService;



class SystemInvoiceService
{
    protected $systemInvoiceRepository;
    protected $userCreationService;
    protected $officeCreationService;
    protected $brokerCreationService;


    public function __construct(SystemInvoiceRepositoryInterface $systemInvoiceRepository,UserCreationService $userCreationService,OfficeCreationService $officeCreationService,BrokerCreationService $brokerCreationService)
    {
        $this->systemInvoiceRepository = $systemInvoiceRepository;
        $this->userCreationService = $userCreationService;
        $this->officeCreationService = $officeCreationService;
        $this->brokerCreationService = $brokerCreationService;
    }

    public function index()
    {
        return $this->systemInvoiceRepository->all();
    }

    public function create(array $data)
    {
        return $this->systemInvoiceRepository->create($data);
    }

    public function find($id)
    {
        return $this->systemInvoiceRepository->find($id);
    }

    public function findByBrokerId($brokerId)
    {
        return $this->systemInvoiceRepository->findByBrokerId($brokerId);
    }

    public function findByOfficeId($officeId)
    {
        return $this->systemInvoiceRepository->findByOfficeId($officeId);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'city_id' => 'required|exists:cities,id',
            'company_logo' => 'required|file',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'CRN' => [
                'required',
                Rule::unique('offices'),
                'max:25'
            ],
            'presenter_number' => [
                'required',
                Rule::unique('offices'),
                'max:25'
            ],
            'presenter_name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];
        $messages = [
            'name.required' => 'The ' . __('name') . ' field is required.',
            'email.required' => 'The ' . __('email') . ' field is required.',
            'presenter_number.required' => 'The ' . __('Company representative number') . ' field is required.',
        ];
        $request->validate($rules, $messages);

        $this->processFileUpload($request->file('company_logo'));

             // User creation
        $user = $this->userCreationService->createOffice($request->all());

             // Office creation
        $office = $this->officeCreationService->createOffice($request->all(), $user);

        $subscription = $this->createSubscription($request, $office);

        $this->createInvoice($request, $subscription, $office);

        return redirect()->route('Admin.Subscribers.index')->withSuccess(__('added successfully'));
    }

    private function processFileUpload($file)
    {
        $ext = uniqid() . '.' . $file->clientExtension();
        $file->move(public_path() . '/Offices/' . 'Logos/', $ext);
        return '/Offices/' . 'Logos/' . $ext;
    }



    private function createSubscription($request, $office)
    {
        $subscriptionType = SubscriptionType::find($request->subscription_type_id);
        $startDate = Carbon::now();
        $endDate = $subscriptionType->calculateEndDate($startDate)->format('Y-m-d');
        $status = $subscriptionType->price > 0 ? 'pending' : 'active';

        return Subscription::create([
            'office_id' => $office->id,
            'subscription_type_id' => $request->subscription_type_id,
            'status' => $status,
            'is_start' => $status == 'pending' ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => $endDate,
            'total' => '200'
        ]);
    }

    public function createInvoice($request, $subscription, $office)
    {
        $subscriptionType = SubscriptionType::find($request->subscription_type_id);
        $status = $subscriptionType->price > 0 ? 'pending' : 'paid';
        $Last_invoice_ID = SystemInvoice::where('invoice_ID', '!=', null)->latest()->value('invoice_ID');
        $delimiter = '-';
        $new_invoice_ID = !$Last_invoice_ID ? '00001' : str_pad((int)explode($delimiter, $Last_invoice_ID)[1] + 1, 5, '0', STR_PAD_LEFT);

        $data = [
            'office_id' => $office->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => $status == 'pending' ? 'paid' : 'free',
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
        ];

        return $this->systemInvoiceRepository->create($data);
    }
}
