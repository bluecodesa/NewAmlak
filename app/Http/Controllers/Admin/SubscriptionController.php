<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\City;
use App\Models\Office;
use App\Models\Region;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribers = Subscription::all();

        return view('Admin.subscribers.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        $subscriptionTypes = SubscriptionType::all();
        return view('Admin.admin.subscriptions.create', get_defined_vars());
    }

    public function createBroker()
    {
        return view('Admin.admin.subscriptions.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password)
        ]);

        $office = Office::create([
            'user_id' => $user->id,
            'CRN' => $request->CRN,
            'company_name' => $user->name,
            'city_id' => $request->city_id,
            'created_by' => Auth::id(),
            'presenter_name' => $request->presenter_name,
            'presenter_number' => $request->presenter_number,
        ]);
        $Subscription  = Subscription::create([
            'office_id' => $office->id,
            'subscription_type_id' => $request->subscription_type_id,
            'status' => 'new',
            'is_new' => 1,
            'start_date' => now(),
            'end_date' => '2024-04-10',
            'total' => '200'
        ]);
        return redirect()->route('Admin.Subscribers.index')
            ->withSuccess(__('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
