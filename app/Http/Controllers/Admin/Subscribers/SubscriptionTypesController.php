<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Section;
use App\Models\SubscriptionType;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Admin\SectionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionTypesController extends Controller
{
    protected $subscriptionTypeService;
    protected $SectionService;

    public function __construct(SubscriptionTypeService $subscriptionTypeService,SectionService $SectionService)
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
        $this->SectionService = $SectionService;
    }

    public function index(Request $request)
    {
        $status_filter = $request->input('status_filter') ?? 'all';
        $period_filter = $request->input('period_filter') ?? 'all';
        $price_filter = $request->input('price_filter') ?? 'all';

        $types = $this->subscriptionTypeService->getAllFiltered($status_filter, $period_filter, $price_filter);
        $prices = $this->calculateRange($types->pluck('price')->toArray());

        return view('Admin.admin.Subscriptions.SubscriptionType.index', [
            'subscriptions' => $types,
            'status_filter' => $status_filter,
            'period_filter' => $period_filter,
            'price_filter' => $price_filter,
            'prices' => $prices,
        ]);
    }

    public function create()
    {
        $roles = Role::where('type', 'user')->get();
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
            'period' => 'required',
            'period_type' => 'required',
            'roles*' => 'required',
            'sections*' => 'required',
        ];
        $messages = [
            'required' => __('The :attribute field is required.'),
            'unique' => __('The :attribute has already been taken.'),
        ];
        $request->validate($rules, $messages);

        $subscriptionType = $this->subscriptionTypeService->createSubscriptionType($request->all());

        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('added successfully'));
    }

    public function edit($id)
    {
        $SubscriptionType = $this->subscriptionTypeService->getSubscriptionTypeById($id);
        $roles = Role::where('type', 'user')->get();
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
            'period' => 'required',
            'period_type' => 'required',
            'roles*' => 'required',
            'sections*' => 'required',
        ];
        $request->validate($rules);

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
