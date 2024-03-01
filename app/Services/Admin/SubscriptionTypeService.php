<?php

// app/Services/SubscriptionTypeService.php

namespace App\Services\Admin;


use App\Repositories\Admin\SubscriptionTypeRepository;
use Illuminate\Validation\Rule;

class SubscriptionTypeService
{

        protected $subscriptionTypeRepository;

        public function __construct(SubscriptionTypeRepository $subscriptionTypeRepository)
        {
            $this->subscriptionTypeRepository = $subscriptionTypeRepository;
        }

        public function index($statusFilter, $periodFilter, $priceFilter)
        {
            return $this->subscriptionTypeRepository->index($statusFilter, $periodFilter, $priceFilter);
        }

        public function calculateRange($counts)
        {
            return $this->subscriptionTypeRepository->();
        }

    public function create()
    {
        return $this->subscriptionTypeRepository->create();
    }

    public function store(array $data)
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

        // Validate the request data
        $validatedData = validator($data, $rules)->validate();

        return $this->subscriptionTypeRepository->store($validatedData);
    }

    public function edit($id)
    {
        return $this->subscriptionTypeRepository->edit($id);
    }

    public function update(array $data, $id)
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

        // Validate the request data
        $validatedData = validator($data, $rules)->validate();

        return $this->subscriptionTypeRepository->update($validatedData, $id);
    }

    public function deleteMultiType($ids)
    {
        return $this->subscriptionTypeRepository->deleteMultiType($ids);
    }

    public function destroy($id)
    {
        return $this->subscriptionTypeRepository->destroy($id);
    }
}






<!-- <?php

// app/Services/SubscriptionTypeService.php

namespace App\Services\Admin;

use App\Repositories\Admin\SubscriptionTypesRepository;


class SubscriptionTypeService
{

    protected $subscriptionTypeRepository;

    public function __construct(SubscriptionTypesRepository $subscriptionTypeRepository)
    {
        $this->subscriptionTypeRepository = $subscriptionTypeRepository;
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


    public function index($status_filter, $period_filter, $price_filter)
    {

        $types = $this->applyFilters(SubscriptionType::where('is_deleted', 0), $status_filter, $period_filter, $price_filter);
        $prices = $this->calculateRange($types->pluck('price')->toArray());

        $types = $types->get();

        return view('Admin.admin.Subscriptions.SubscriptionType.index', [
            'subscriptions' => $types,
            'status_filter' => $status_filter, 'period_filter' => $period_filter, 'price_filter' => $price_filter,
            'prices' => $prices
        ]);
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

    private function validateSubscription($request, $period, $period_type, $type = null)
    {
        $request->validate([
            'price' => 'required',
            'status' => 'required',
            'period' => [
                'required',
                Rule::unique('subscription_types')
                    ->ignore($type ? $type->id : null)
                    ->where(function ($query) use ($period, $period_type) {
                        return $query->where('period', $period)
                            ->where('period_type', $period_type)
                            ->where('is_deleted', 0);
                    }),
            ],
        ], ['period.unique' => "تم اضافة هذا الاشتراك من قبل"]);
    }


    private function shouldUpdateType($request, $type)
    {
        return $request->price != $type->price || $request->period != $type->period ||
            $request->period_type != $type->period_type;
    }


    public function edit($id)
    {
        $SubscriptionType = $this->find($id);

        $roles = Role::where('type', 'user')->get();
        $sections = Section::get();
        $rolesIds = $SubscriptionType->RolesData->pluck('role_id')->toArray();
        $sectionIds = $SubscriptionType->SectionData->pluck('section_id')->toArray();
        return view('Admin.admin.Subscriptions.SubscriptionType.edit', get_defined_vars());
    }

    public function find($id)
    {
        // ... (same as in the repository)
        return SubscriptionType::with(['SectionData', 'RolesData'])->find($id);
    }

    public function getBy($arr)
    {
        // ... (same as in the repository)
        return SubscriptionType::where($arr)->get();
    }

    public function getAll()
    {
        // ... (same as in the repository)
        return SubscriptionType::where('is_deleted', 0)->get();
    }

    public function deleteMultiType($array)
    {
        // ... (same as in the repository)
        $ids = explode(",", $array);
        SubscriptionType::whereIn('id', $ids)->update(['is_deleted' => 1]);
        toastr()->success("تم الحذف  بنجاح");
        return  back();
    }

    public function deleteType($id)
    {
        SubscriptionType::where(['id' => $id])->update(['is_deleted' => 1]);
        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('Deleted successfully'));
    }

    public function getSubscriptionTypesByRole($roleName)
    {
        if ($roleName === 'Office-Admin') {
            return $this->subscriptionTypeRepository->getSubscriptionTypesForOfficeAdmin();
        } elseif ($roleName === 'RS-Broker') {
            return $this->subscriptionTypeRepository->getSubscriptionTypesForRSBroker();
        } else {
            return $this->subscriptionTypeRepository->getAll();
        }
    }
} -->
