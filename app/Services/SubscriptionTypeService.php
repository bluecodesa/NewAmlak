<?php

// app/Services/SubscriptionTypeService.php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SubscriptionTypeService
{
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

        return view('Admin.admin.subscriptions.index', [
            'subscriptions' => $types,
            'status_filter' => $status_filter, 'period_filter' => $period_filter, 'price_filter' => $price_filter,
            'prices' => $prices
        ]);
    }

    // ... other methods

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
        // $roles = Role::all();
        $allowedRoles = ['Rs_admin', 'Broker'];
        $roles = Role::whereIn('name', $allowedRoles)->get();

        return view('Admin.admin.subscriptions.create')->with('roles', $roles);
    }


    public function store(Request $request)
    {

        $period = $request['period'];
        $period_type = $request['period_type'];

        $this->validateSubscription($request, $period, $period_type);

        $subscriptionType = SubscriptionType::create($request->all());

        $roles = $request->input('roles', []);
        $subscriptionType->syncRoles($roles);

        // Flash a success message to the session
        toastr()->success("تم اضافة نوع الاشتراك بنجاح");

        // Redirect back to the index page or any other page you prefer
        return redirect()->route('SubscriptionTypes.index');
    }

    public function update(Request $request, $id)
    {
        // ... (same as in the repository)
        $period = $request['period'];
        $period_type = $request['period_type'];
        $type = SubscriptionType::find($id);

        $this->validateSubscription($request, $period, $period_type, $type);

        if ($this->shouldUpdateType($request, $type)) {
            SubscriptionType::where(['id' => $id])->update(['is_deleted' => 1]);
            SubscriptionType::create($request->all());
        } else {
            $type->update($request->all());
        }

        toastr()->success("تم تعديل نوع الاشتراك بنجاح");

        return redirect()->route('Admin.SubscriptionTypes.index');
    }

    private function validateSubscription($request, $period, $period_type, $type = null)
    {
        $request->validate([
            'price' => 'required',
            'status' => 'required',
            'period' => [
                'required',
                Rule::unique('subscription_types')->ignore($type ? $type->id : null)->where(function ($query) use ($period, $period_type) {
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
        $sub = $this->find($id);
        $users = Subscription::where('subscriptions_type', $sub->period)->get();
        $access = count($users) > 0 ? false : true;

        return view('Admin.admin.subscriptions.edit', ['sub' => $sub, 'access' => $access]);
    }

    public function find($id)
    {
        // ... (same as in the repository)
        return SubscriptionType::find($id);
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
        // ... (same as in the repository)
        SubscriptionType::where(['id' => $id])->update(['is_deleted' => 1]);
        toastr()->success("تم حذف نوع الاشتراك بنجاح");
        return  back();
    }
}
