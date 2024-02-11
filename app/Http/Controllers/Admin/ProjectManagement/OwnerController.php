<?php

namespace App\Http\Controllers\Admin\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Advisor;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Region;
use Illuminate\Validation\Rule;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::all();
        return view('Admin.ProjectManagement.Owner.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        return view('Admin.ProjectManagement.Owner.create', get_defined_vars());
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
        $request->validate($rules);
        Owner::create($request->all());
        return redirect()->route('Admin.Owner.index')->with('success', __('added successfully'));
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
        $developer = Advisor::find($id);
        $cities = City::all();
        return view('Admin.ProjectManagement.Owner.edit', get_defined_vars());
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
        return redirect()->route('Admin.Owner.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        Owner::find($id)->delete();
        return redirect()->route('Admin.Owner.index')->with('success', __('Deleted successfully'));
    }
}
