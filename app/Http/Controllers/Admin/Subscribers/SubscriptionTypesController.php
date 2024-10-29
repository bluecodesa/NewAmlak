<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Admin\SectionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionTypesController extends Controller
{
    protected $subscriptionTypeService;
    protected $SectionService;
    protected $roleService;


    public function __construct(
        SubscriptionTypeService $subscriptionTypeService,
        SectionService $SectionService,
        RoleService $roleService

    ) {
        $this->subscriptionTypeService = $subscriptionTypeService;
        $this->SectionService = $SectionService;
        $this->roleService = $roleService;

        $this->middleware(['role_or_permission:read-SubscriptionTypes'])->only('index');
        $this->middleware(['role_or_permission:create-SubscriptionTypes'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-SubscriptionTypes'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-SubscriptionTypes'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $status_filter = $request->input('status_filter') ?? 'all';
        $period_filter = $request->input('period_filter') ?? 'all';
        $price_filter = $request->input('price_filter') ?? 'all';

        $types = $this->subscriptionTypeService->getAllFiltered($status_filter, $period_filter, $price_filter);
        $prices = $this->calculateRange($types->pluck('price')->toArray());
        $subscriptionsDeleted = $this->subscriptionTypeService->getSubscriptionTypeAll()->where('is_deleted', 1);
        return view('Admin.admin.Subscriptions.SubscriptionType.index', [
            'subscriptions' => $types,
            'status_filter' => $status_filter,
            'period_filter' => $period_filter,
            'price_filter' => $price_filter,
            'prices' => $prices,
            'subscriptionsDeleted' => $subscriptionsDeleted,

        ]);
    }

    public function create()
    {
        // $roles = Role::where('type', 'user')->get();
        $roles = $this->roleService->getAllRoles();
        $sections = $this->SectionService->getAll();

        return view('Admin.admin.Subscriptions.SubscriptionType.create', compact('roles', 'sections'));
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('subscription_type_translations', 'name')]];
        }
        $rules += [
            'period' => 'required|numeric|min:1',
            'period_type' => 'required',
            'roles' => 'required|array|min:1',
            'sections' => 'required|array',
            'upgrade_rate' => 'nullable|numeric|min:0|max:100',
            'views_discount' => 'nullable|numeric|min:0|max:100',
            'ads_discount' => 'nullable|numeric|min:0|max:100',
            'price' => 'required|numeric|min:0',
            'new_subscriber' => [
                'required',
                Rule::in(['0', '1'])
            ],

        ];
        $messages = [
            'required' => __('The :attribute field is required.'),
            'numeric' => __('The :attribute field must be number.'),
            'period.min' => __('The period must be at least 1 day.'),
            'unique' => __('The :attribute has already been taken.'),
            'roles.min' => __('Please select at least one role.'),
            'upgrade_rate.numeric' => 'Discount applied Must be Number ',
            'price.required' => __('The price field is required.'), // Add this line for price error message
            'price.numeric' => __('The price must be a number.'), // Add this line for numeric validation message
            'price.min' => __('The price must be at least 0.'), // Add this line for minimum value validation


        ];
        $request->validate($rules, $messages);

        $subscriptionType = $this->subscriptionTypeService->createSubscriptionType($request->all());

        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('added successfully'));
    }

    public function edit($id)
    {
        $SubscriptionType = $this->subscriptionTypeService->getSubscriptionTypeById($id);
        // $roles = Role::where('type', 'user')->get();
        $roles = $this->roleService->getAllRoles();
        $sections = $this->SectionService->getAll();
        $rolesIds = $SubscriptionType->RolesData->pluck('role_id')->toArray();
        $sectionIds = $SubscriptionType->SectionData->pluck('section_id')->toArray();

        return view('Admin.admin.Subscriptions.SubscriptionType.edit', compact('SubscriptionType', 'roles', 'sections', 'rolesIds', 'sectionIds'));
    }

    public function update(Request $request, $id)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('subscription_type_translations', 'name')->ignore($id, 'subscription_type_id')]];
        }
        $rules += [
            'period' => 'required|numeric|min:1',
            'period_type' => 'required',
            'roles*' => 'required',
            'sections*' => 'required',
            'upgrade_rate' => 'nullable|numeric|min:0|max:100',
            'price' => 'required|numeric|min:0', // Add this line for price validation
            'new_subscriber' => [
                'required',
                Rule::in(['0', '1'])
            ],


        ];
        $messages = [
            'required' => __('The :attribute field is required.'),
            'numeric' => __('The :attribute field must be number.'),
            'period.min' => __('The period must be at least 1 day.'),
            'unique' => __('The :attribute has already been taken.'),
            'roles.min' => __('Please select at least one role.'),
            'upgrade_rate.numeric' => 'Discount applied Must be Number ',
            'price.required' => __('The price field is required.'), // Add this line for price error message
            'price.numeric' => __('The price must be a number.'), // Add this line for numeric validation message
            'price.min' => __('The price must be at least 0.'), // Add this line for minimum value validation


        ];
        $request->validate($rules, $messages);
        $this->subscriptionTypeService->updateSubscriptionType($id, $request->all());

        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->subscriptionTypeService->deleteSubscriptionType($id);

        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('Deleted successfully'));
    }

    public function deleteMultiType($array)
    {
        $ids = explode(",", $array);
        foreach ($ids as $id) {
            $this->subscriptionTypeService->deleteSubscriptionType($id);
        }

        toastr()->success("تم الحذف بنجاح");
        return redirect()->back();
    }

    private function calculateRange($counts)
    {
        $uniqueCounts = array_unique($counts);

        if (count($uniqueCounts) <= 1) {
            return $uniqueCounts ? [$uniqueCounts[0]] : [0];
        }

        sort($uniqueCounts);
        $min = 0;
        $max = end($uniqueCounts);
        $diff = $max - $min;
        $period = ceil($diff / 3);

        $result = [];

        for ($i = 1; $i <= 2; $i++) {
            $result[] = $min + $i * $period;
        }
        $result[] = $max;

        return $result;
    }
}
