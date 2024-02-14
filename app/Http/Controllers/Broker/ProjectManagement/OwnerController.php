<?php

namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Advisor;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::where('broker_id', Auth::user()->UserBrokerData->id)->with(['BrokerData.UserData'])->get();
        return view('Broker.ProjectManagement.Owner.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        return view('Broker.ProjectManagement.Owner.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('owners')->ignore($request->id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('owners')->ignore($request->id),
                'max:25'
            ],
        ];
        $request_data = $request->all();
        $request_data['broker_id'] = Auth::user()->UserBrokerData->id;
        $request->validate($rules);
        Owner::create($request_data);
        return redirect()->route('Broker.Owner.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $Regions = Region::all();
        $Owner = Owner::find($id);
        $cities = City::all();
        return view('Broker.ProjectManagement.Owner.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $Owner = Owner::find($id);
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('owners')->ignore($Owner->id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('owners')->ignore($Owner->id),
                'max:25'
            ],
        ];
        $request->validate($rules);
        $Owner->update($request->all());
        return redirect()->route('Broker.Owner.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        Owner::find($id)->delete();
        return redirect()->route('Broker.Owner.index')->with('success', __('Deleted successfully'));
    }
}
