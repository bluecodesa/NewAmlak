<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\City;
use App\Models\SubscriptionType;
use App\Models\SubUser;
use Illuminate\Http\Request;

class SubUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subscribers = SubUser::all();
        $brokers=Broker::all();
        $subscriptionTypes = SubscriptionType::where('status', 1)->get();
        $cities = City::all();
        return view('Admin.subscribers.index', get_defined_vars());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'license_number' => 'required|string',
        'email' => 'required|email|unique:brokers,email',
        'mobile' => 'required|string',
        'city' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
        'subscription_type' => 'required|string',
        'id_number' => 'required|string',
    ]);

    $subscriptionType = SubscriptionType::findOrFail($request->subscription_type);


    Broker::create([
        'name' => $request->name,
        'license_number' => $request->license_number,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'city' => $request->city,
        'password' => bcrypt($request->password),
        'subscription_type_id' => $subscriptionType->id, // Associate the subscription type ID
        'id_number' => $request->id_number,
    ]);

    return redirect()->route('Admin.Subscribers.index')
        ->with('success', 'Broker created successfully.');
}
    public function createBrokerSubscribers(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:brokers,email',
            'license_number' => 'required|string',
            'mobile' => 'required|string',
            'city' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'subscription_type' => 'required|string',
            'id_number' => 'required|string',
        ]);

        Broker::create([
            'name' => $request->name,
            'email' => $request->email,
            'license_number' => $request->license_number,
            'mobile' => $request->mobile,
            'city' => $request->city,
            'password' => bcrypt($request->password),
            'subscription_type' => $request->subscription_type,
            'id_number' => $request->id_number,
        ]);

        return redirect()->route('Admin.Subscribers.index')
            ->with('success', 'Broker added successfully.');
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
