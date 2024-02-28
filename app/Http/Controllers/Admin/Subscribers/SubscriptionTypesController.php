<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Http\Controllers\Controller;

use App\Interfaces\Admin\SubscriptionTypesRepositoryInterface;
use App\Http\Requests\SubscriptionTypeRequest;
use App\Models\Role;
use App\Models\Section;
use App\Models\SubscriptionType;
use App\Models\SubscriptionTypeRole;
use App\Models\SubscriptionTypeSection;
use App\Services\Admin\SubscriptionTypeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionTypesController extends Controller
{


    public function index()
    {
        $status_filter = request()->input('status_filter') ?? 'all';
        $period_filter = request()->input('period_filter') ?? 'all';
        $price_filter = request()->input('price_filter') ?? 'all';

        $types = $this->applyFilters(SubscriptionType::where('is_deleted', 0), $status_filter, $period_filter, $price_filter);
        $prices = $this->calculateRange($types->pluck('price')->toArray());

        $types = $types->get();
        return view('Admin.admin.Subscriptions.SubscriptionType.index', [
            'subscriptions' => $types,
            'status_filter' => $status_filter, 'period_filter' => $period_filter, 'price_filter' => $price_filter,
            'prices' => $prices
        ]);

        // return $this->subtypeRepo->index($status_filter, $period_filter, $price_filter);
    }

    public function create()
    {
        $roles = Role::where('type', 'user')->get();
        $sections = Section::get();
        return view('Admin.admin.Subscriptions.SubscriptionType.create', get_defined_vars());
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
        $request->validate($rules);
        $period = $request['period'];
        $period_type = $request['period_type'];

        $this->validateSubscription($request, $period, $period_type);

        $subscriptionType = SubscriptionType::create($request->except(['roles', 'sections']));

        foreach ($request->sections as $section) {
            SubscriptionTypeSection::create(['subscription_type_id' => $subscriptionType->id, 'section_id' => $section]);
        }

        foreach ($request->roles as $role) {
            SubscriptionTypeRole::create(['subscription_type_id' => $subscriptionType->id, 'role_id' => $role]);
        }

        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('added successfully'));
    }

    public function edit($id)
    {

        $SubscriptionType =  SubscriptionType::with(['SectionData', 'RolesData'])->find($id);;

        $roles = Role::where('type', 'user')->get();
        $sections = Section::get();
        $rolesIds = $SubscriptionType->RolesData->pluck('role_id')->toArray();
        $sectionIds = $SubscriptionType->SectionData->pluck('section_id')->toArray();
        return view('Admin.admin.Subscriptions.SubscriptionType.edit', get_defined_vars());
    }

    public function update(Request $request,  $id)
    {
        $subscriptionType = SubscriptionType::find($id);
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('subscription_type_translations', 'name')->ignore($subscriptionType->id, 'subscription_type_id')]];
        }
        $rules += [
            'period' => 'required',
            'period_type' => 'required',
            'roles*' => 'required',
            'sections*' => 'required',
        ];
        $request->validate($rules);

        $period = $request['period'];
        $period_type = $request['period_type'];

        // $this->validateSubscription($request, $period, $period_type);

        $subscriptionType->update($request->except(['roles', 'sections']));

        // Sync sections
        $subscriptionType->sections()->sync($request->sections);

        // Sync roles
        $subscriptionType->roles()->sync($request->roles);

        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('Update successfully'));
    }


    public function deleteMultiType($array)
    {
        // ... (same as in the repository)
        $ids = explode(",", $array);
        SubscriptionType::whereIn('id', $ids)->update(['is_deleted' => 1]);
        toastr()->success("تم الحذف  بنجاح");
        return  back();
    }

    public function destroy($id)
    {
        SubscriptionType::where(['id' => $id])->update(['is_deleted' => 1]);
        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('Deleted successfully'));
    }


    private function applyFilters($query, $status_filter, $period_filter, $price_filter)
    {
        if (!is_null($status_filter) && $status_filter != '' && $status_filter != 'all') {
            $query->where('status', $status_filter);
        }

        if (!is_null($period_filter) && $period_filter != '' && $period_filter != 'all') {
            $query->where('period_type', $period_filter);
        }

        if (!is_null($price_filter) && $price_filter != '' && $price_filter != 'all') {
            $query = $price_filter == 0 ? $query->where('price', '=', 0) : $query->where('price', '<=', $price_filter);
        }

        return $query;
    }

    public function calculateRange($counts)
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
