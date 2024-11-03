<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Models\City;
use App\Models\District;
use App\Models\Gallery;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Property;
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
        $officeId = auth()->user()->UserOfficeData->id;
        $numberOfowners = $this->ownerService->getAllByofficeId($officeId)->count();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $numberOfUnits = $this->UnitService->getAll($officeId)->count();
        $counts = $this->UnitService->countUnitsForOffice($officeId);
        $residentialCount = $counts['residential'];
        $nonResidentialCount = $counts['non_residential'];
        $numberOfInterests = $this->unitInterestService->getNumberOfInterests();
        $numberOfVacantUnits = $this->UnitService->getAll($officeId)->where('status', 'vacant')->count();
        $numberOfRentedUnits = $this->UnitService->getAll($officeId)->where('status', 'rented')->count();
        if ($user && $user->is_office && $user->UserOfficeData) {
            $subscription = $user->UserOfficeData->UserSubscriptionPending;
            $pendingPayment = $subscription && $subscription->status === 'pending';
        }

        $subscriber = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
        $SubscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($subscriber->subscription_type_id);

        //
        $sectionNames = [];
        if ($subscriber) {
            $subscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($subscriber->subscription_type_id);
            $hasRealEstateGallerySection = $subscriptionType->sections()->get();
            $sectionNames = $hasRealEstateGallerySection->pluck('name')->toArray();
        }

        //
        $UserSubscriptionTypes = $this->SubscriptionTypeService->getUserSubscriptionTypes()->where('is_deleted', 0)->where('status', 1);

        //statistics calc

        $start_date = \Carbon\Carbon::parse($subscriber->start_date);
        $end_date = \Carbon\Carbon::parse($subscriber->end_date);
        $now = now();

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


        $gallery = $this->galleryService->findByofficeId($officeId);
        $visitorCount = 0;

        if ($gallery !== null) {
            $visitorCount += $gallery->visitors()->distinct('ip_address')->count('ip_address');
        }

        $tickets = $this->ticketService->getUserTickets(auth()->id());
        $requests = $this->RealEstateRequestService->getAll();


        // mapbox

        $allItems = collect();
        $units = $this->UnitService->getAll(auth()->user()->UserOfficeData->id);
        $projects = $this->ProjectService->getAllProjectsByOfficeId(auth()->user()->UserOfficeData->id);
        $properties = $this->PropertyService->getAll(auth()->user()->UserOfficeData->id);

        $units->each(function ($unit) {
            $unit->isGalleryUnit = true;
            $unit->rentPrice =$unit->getRentPriceByType() ?? '';
            $unit->rent_type_show =  __($unit->rent_type_show) ?? null;
            $unit->ProjectData =$unit->ProjectData ?? null;
            $unit->PropertyData =$unit->PropertyData ?? null;


        });
        $projects->each(function ($project) {
            $project->isGalleryProject = true;
        });
        $properties->each(function ($property) {
            $property->isGalleryProperty = true;
            $property->ProjectData =$property->ProjectData ?? null;
        });

        $galleryItems = $projects->merge($properties)->merge($units);
        $allItems = $allItems->merge($galleryItems);

        $propertyTypes = $allItems->pluck('PropertyTypeData')->filter()->unique();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $cities = $allItems->pluck('CityData')->unique();
        $districts = $allItems->pluck('DistrictData')->unique();
        $projects = Project::all();

        $allItemsProperties = collect();

        $galleries = Gallery::whereNotNull('office_id')->where('gallery_status', 1)->get();

        foreach ($galleries as $gallery) {
            $projects = $this->ProjectService->getAllProjectsByOfficeId($gallery['office_id'])->where('show_in_gallery', 1);
            $properties = $this->PropertyService->getAll($gallery['office_id'])->where('show_in_gallery', 1);
            $galleryUnits = Unit::where('office_id', $gallery->office_id)
                ->where('show_in_gallery', 1)
                ->get();

            $galleryUnits->each(function ($unit) {
                $unit->isGalleryUnit = true;
            });
            $projects->each(function ($project) {
                $project->isGalleryProject = true;
            });
            $properties->each(function ($property) {
                $property->isGalleryProperty = true;
            });

            $galleryItems = $projects->merge($properties)->merge($galleryUnits);
            $allItemsProperties = $allItemsProperties->merge($galleryItems);
            $propertyTypesAll = $allItemsProperties->pluck('PropertyTypeData')->filter()->unique();
            $usagesAll =  $this->propertyUsageService->getAllPropertyUsages();
            $citiesAll = $allItemsProperties->pluck('CityData')->unique();
            $districtsAll = $allItemsProperties->pluck('DistrictData')->unique();
        }

        // end mapbox
      // اجلب عدد الإعلانات الصالحة المنشورة
        $x = Project::where('office_id', $officeId)
        ->where('ad_license_status', 'Valid')->count()
        + Property::where('office_id', $officeId)
        ->where('ad_license_status', 'Valid')->count()
        + Unit::where('office_id', $officeId)
        ->where('ad_license_status', 'Valid')->count();
    //             $x= Unit::where('office_id', $officeId)->where('ad_license_status', 'Valid')->count();
    // dd($x);
        // اجلب عدد المشاهدات لكل الإعلانات الخاصة بالمستخدم
        $y = Visitor::where(function($query) use ($officeId) {
            $query->whereIn('project_id', Project::where('office_id', $officeId)->pluck('id'))
                    ->orWhereIn('property_id', Property::where('office_id', $officeId)->pluck('id'))
                    ->orWhereIn('unit_id', Unit::where('office_id', $officeId)->pluck('id'));
        })
        ->whereBetween('visited_at', [$start_date, $end_date]) // Filter by subscription dates
        ->count();



        Auth::user()->assignRole('Office-Admin');
        session(['active_role' => 'Office-Admin']);
        return view('Office.dashboard',  get_defined_vars());
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
            $x = Project::where('office_id', $officeId)
            ->where('ad_license_status', 'Valid')->count()
            + Property::where('office_id', $officeId)
            ->where('ad_license_status', 'Valid')->count()
            + Unit::where('office_id', $officeId)
            ->where('ad_license_status', 'Valid')->count();
//             $x= Unit::where('office_id', $officeId)->where('ad_license_status', 'Valid')->count();
// dd($x);
            // اجلب عدد المشاهدات لكل الإعلانات الخاصة بالمستخدم
            $y = Visitor::where(function($query) use ($officeId) {
                $query->whereIn('project_id', Project::where('office_id', $officeId)->pluck('id'))
                      ->orWhereIn('property_id', Property::where('office_id', $officeId)->pluck('id'))
                      ->orWhereIn('unit_id', Unit::where('office_id', $officeId)->pluck('id'));
            })
            ->whereBetween('visited_at', [$start_date, $end_date]) // Filter by subscription dates
            ->count();


        return view('Office.SubscriptionManagement.show', get_defined_vars());
    }

    public function ShowInvoice($id)
    {
        $invoice = $this->systemInvoiceRepository->find($id);

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
