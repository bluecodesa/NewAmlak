<?php

namespace App\Http\Controllers\ServicePovider;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Models\BankAccount;
use App\Models\City;
use App\Models\District;
use App\Models\Gallery;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Property;
use App\Models\Receipt;
use App\Models\Renter;
use App\Models\Subscription;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionType;
use App\Models\SystemInvoice;
use App\Models\UnitInterest;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\User;
use App\Models\Visitor;
use App\Notifications\Admin\ReceiptUploadNotification;
use App\Services\Admin\RegionService as AdminRegionService;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\RegionService;
use App\Services\CityService;
use App\Services\Office\OwnerService;
use App\Services\Office\UnitService;
use App\Services\Office\GalleryService;
use App\Services\Office\UnitInterestService;
use App\Services\PropertyUsageService;
use App\Services\Admin\SectionService;
use App\Services\Broker\TicketService;
use App\Services\RealEstateRequestService;
use App\Services\Office\ProjectService;
use App\Services\Office\PropertyService;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    protected $subscriptionService;
    protected $regionService;
    protected $RegionService;
    protected $districtService;
    protected $cityService;
    protected $ownerService;
    protected $UnitService;
    protected $SubscriptionTypeService;
    protected $propertyUsageService;

    protected $galleryService;
    protected $systemInvoiceRepository;
    protected $unitInterestService;
    protected $SectionService;
    protected $RealEstateRequestService;

    protected $ticketService;

    protected $ProjectService;
    protected $PropertyService;




    public function __construct(
        SystemInvoiceRepositoryInterface $systemInvoiceRepository,
        UnitService $UnitService,
        SubscriptionService $subscriptionService,
        RegionService $regionService,
        AdminRegionService $RegionService,
        DistrictService $districtService,
        CityService $cityService,
        OwnerService $ownerService,
        SubscriptionTypeService $SubscriptionTypeService,
        GalleryService $galleryService,
        PropertyUsageService $propertyUsageService,
        UnitInterestService $unitInterestService,
        SectionService $SectionService,
        TicketService $ticketService,
        RealEstateRequestService $RealEstateRequestService,
        ProjectService $ProjectService,
        PropertyService $PropertyService

    ) {
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;
        $this->regionService = $regionService;
        $this->RegionService = $RegionService;
        $this->districtService = $districtService;
        $this->cityService = $cityService;
        $this->ownerService = $ownerService;
        $this->UnitService = $UnitService;
        $this->galleryService = $galleryService;
        $this->propertyUsageService = $propertyUsageService;
        $this->systemInvoiceRepository = $systemInvoiceRepository;
        $this->unitInterestService = $unitInterestService;
        $this->SectionService = $SectionService;
        $this->ticketService = $ticketService;
        $this->RealEstateRequestService = $RealEstateRequestService;

        $this->ProjectService = $ProjectService;
        $this->PropertyService = $PropertyService;

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $ServicePoviderId = auth()->user()->UserServiceProviderData->id;
        $numberOfowners = 0;
        $numberOfUnits = 0;
        $numberOfVacantUnits  = 0;
        $tickets = null;
        $sectionsIds = [];
        $numberOfRentedUnits =0;

        Auth::user()->assignRole('service-povider');
        session(['active_role' => 'service-povider']);
        return view('ServicePovider.dashboard',  get_defined_vars());
    }

    public function GetCitiesByRegion($id)
    {
        // $cities = City::where('region_id', $id)->get();
        $cities = $this->RegionService->getCityByRegionId($id);
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }

    function ViewInvoice()
    {
        return view('Home.Payments.inc._ViewInvoice');
    }
    function UpdateSubscription($id)
    {
        // $SubscriptionType = SubscriptionType::find($id);
        $SubscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($id);

        $subscription = auth()->user()->UserOfficeData->UserSubscriptionPending;

        $subscription->update(['subscription_type_id' => $id, 'total' => $SubscriptionType->price, 'status' => 'pending']);

        $Invoice  =  auth()->user()->UserOfficeData->UserSystemInvoicePending;
        $Last_invoice_ID = SystemInvoice::where('invoice_ID', '!=', null)->latest()->value('invoice_ID');
        $delimiter = '-';
        $new_invoice_ID = !$Last_invoice_ID ? '00001' : str_pad((int)explode($delimiter, $Last_invoice_ID)[1] + 1, 5, '0', STR_PAD_LEFT);

        $data = [
            'broker_id' => $subscription->broker_id,
            'office_id' => $subscription->office_id,
            'amount' => $SubscriptionType->price,
            'subscription_name' => $SubscriptionType->name,
            'period' => $SubscriptionType->period,
            'period_type' => $SubscriptionType->period_type,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
            'status' => 'pending'
        ];

        if (!$Invoice) {
            $this->systemInvoiceRepository->create($data);
        } else {
            $Invoice->update(['amount' => $SubscriptionType->price, 'subscription_name' => $SubscriptionType->name, 'period' => $SubscriptionType->period, 'period_type' => $SubscriptionType->period_type]);
        }
    }

    public function GetDistrictsByCity($id)
    {
        // $districts = District::where('city_id', $id)->get();
        $districts = $this->districtService->getDistrictsByCity($id);

        return view('Admin.settings.Region.inc._district', get_defined_vars());
    }

    public function showSubscription()
    {
        $officeId = auth()->user()->UserOfficeData->id;
        $subscriber = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
        $user = Auth::user();
        $start_date = \Carbon\Carbon::parse($subscriber->start_date);
        $end_date = \Carbon\Carbon::parse($subscriber->end_date);
        $now = now();
        if ($user && $user->is_office && $user->UserOfficeData) {
            $subscription = $user->UserOfficeData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }
        $numOfDays = $end_date->diffInDays($start_date);
        $elapsed_days = $now->diffInDays($start_date);
        $daysUntilEnd = $numOfDays - $elapsed_days;

        $hoursUntilEnd = $now->diffInHours($end_date->copy()->subDays($daysUntilEnd), false);
        $minutesUntilEnd = $now->diffInMinutes($end_date, false);

        if ($numOfDays == 0) {
            $prec = 100;
        } else {

            $prec = ($daysUntilEnd / $numOfDays) * 100;
            $prec = round($prec, 1);
        }

        $officeId = auth()->user()->UserOfficeData->id;

        $subscription = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
        if ($officeId)
        $invoices = $this->systemInvoiceRepository->findByOfficeId($officeId);
        $UserSubscriptionTypes = $this->SubscriptionTypeService->getOfficeSubscriptionTypes()->where('is_deleted', 0)->where('status', 1);
        $sections = $this->SectionService->getAll();

        // اجلب عدد الإعلانات الصالحة المنشورة
            $numOfAds = Project::where('office_id', $officeId)
            ->where('ad_license_status', 'Valid')->count()
            + Property::where('office_id', $officeId)
            ->where('ad_license_status', 'Valid')->count()
            + Unit::where('office_id', $officeId)
            ->where('ad_license_status', 'Valid')->count();
//             $x= Unit::where('office_id', $officeId)->where('ad_license_status', 'Valid')->count();
// dd($numOfAds);
            // اجلب عدد المشاهدات لكل الإعلانات الخاصة بالمستخدم
            $numOfViews = Visitor::where(function($query) use ($officeId) {
                $query->whereIn('project_id', Project::where('office_id', $officeId)->where('ad_license_status', 'Valid')->pluck('id'))
                      ->orWhereIn('property_id', Property::where('office_id', $officeId)->where('ad_license_status', 'Valid')->pluck('id'))
                      ->orWhereIn('unit_id', Unit::where('office_id', $officeId)->where('ad_license_status', 'Valid')->pluck('id'));
            })
            ->whereBetween('visited_at', [$start_date, $end_date]) // Filter by subscription dates
            ->count();
// dd($numOfViews);
$receipts = Receipt::where('office_id',auth()->user()->UserOfficeData->id)->get();


        return view('Office.SubscriptionManagement.show', get_defined_vars());
    }

    public function updateReceipt(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);

        if ($receipt->status !== 'Under review') {
            return redirect()->back()->with('error', __('You can only update receipts that are under review.'));
        }

        $validatedData = $request->validate([
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'comment' => 'nullable|string',
        ]);
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;

            $file->move(public_path('Admin/Receipt'), $filename);

            $receipt->receipt = 'Admin/Receipt/' . $filename;
        }

        $receipt->comment = $validatedData['comment'] ?? $receipt->comment;

        $receipt->save();
        $this->notifyRelatedAdmin( $receipt);

        return redirect()->back()->with('success', __('Receipt updated successfully.'));
    }

    protected function notifyRelatedAdmin( $receipt)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new ReceiptUploadNotification($receipt));
        }

    }
    public function showReceipt($id){
        $receipt = Receipt::findOrFail($id);
        return view('Office.SubscriptionManagement.receipts.show' , get_defined_vars());
    }

    public function deleteReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);

        if (!in_array($receipt->status, ['Under review', 'rejected'])) {
            return redirect()->back()->with('error', __('This receipt cannot be deleted as it has already been processed.'));
        }

        $user = Auth::user();
        $officeData = $user->UserOfficeData;

        if (!$officeData || $receipt->OfficeData->user_id !== $user->id) {
            return redirect()->back()->with('error', __('You do not have permission to delete this receipt.'));
        }

        $receipt->delete();

        return redirect()->back()->with('success', __('Receipt deleted successfully.'));
    }


    public function ShowInvoice($id)
    {
        $invoice = $this->systemInvoiceRepository->find($id);
        $bankAccount = BankAccount::where('is_default','1')->where('status','1')->first();

        return view('Office.SubscriptionManagement.invoices.show', get_defined_vars());
    }



    public function searchByIdNumber(Request $request)
    {

        // $this->OwnerService->searchByIdNumber($request);
        $validatedData = $request->validate([
            'id_number' => [
                'required',
                'numeric',
                'digits:10',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
                    }
                },
            ],
        ], [
            'id_number.required' => 'The ID number field is required.',
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
        ]);

        $idNumber = $validatedData['id_number'];
        $officeId = auth()->user()->UserOfficeData->id;

        $user = User::where('id_number', $idNumber)->first();
        if ($user) {
            if ($user->is_owner) {
                $existingOwner = Owner::where('user_id', $user->id)
                    ->whereHas('offices', function ($query) use ($officeId) {
                        $query->where('office_id', $officeId);
                    })
                    ->first();

                if ($existingOwner) {
                    return response()->json([
                        'html' => view('Office.inc._result_search', [
                            'message' => __('User is already a Owner in this office.'),
                            'user' => $user,
                        'id_number'=>$idNumber

                        ])->render()
                    ]);
                } else {
                    return response()->json([
                        'html' => view('Office.inc._no_data_search', [
                            'message' => __('This id number is not registered in this account'),
                            'user' => $user,
                            'id_number'=>$idNumber
                        ])->render()
                    ]);
                }
            }elseif($user->is_renter) {
                $existingRenter = Renter::where('user_id', $user->id)
                    ->whereHas('OfficeData', function ($query) use ($officeId) {
                        $query->where('office_id', $officeId);
                    })
                    ->first();
                    if ($existingRenter) {
                        return response()->json(['html' => view('Office.inc._result_search', ['message' => __('User is already a renter in this office.'), 'user' => $user])->render()]);
                    }
                return response()->json(['html' => view('Office.inc._no_data_search', ['message' => __('This id number is not registered in this account'), 'user' => $user])->render()]);
            }
             else {
                return response()->json([
                    'html' => view('Office.inc._no_data_search', [
                        'message' => __('This id number is not registered in this account'),
                        'user' => $user,
                        'id_number'=>$idNumber
                    ])->render()
                ]);
            }
        } else {
            return response()->json([
                'html' => view('Office.inc._no_data_search', [
                    'message' => __('This id number is not registered in this account'),
                    session(['id_number' => $idNumber]),
                    ])->render()
            ]);
        }

    }

}
