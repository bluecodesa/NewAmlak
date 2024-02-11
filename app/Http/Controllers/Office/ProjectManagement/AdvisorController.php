<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Advisor;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdvisorController extends Controller
{
    public function index()
    {
        $advisors = Advisor::where('office_id', Auth::user()->UserOfficeData->id)->get();
        return view('Office.ProjectManagement.Advisor.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        return view('Office.ProjectManagement.Advisor.create', get_defined_vars());
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
                Rule::unique('advisors')->ignore($request->id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('advisors')->ignore($request->id),
                'max:25'
            ],
        ];
        $request_data = $request->all();
        $request_data['office_id'] = Auth::user()->UserOfficeData->id;
        $request->validate($rules);
        Advisor::create($request_data);
        return redirect()->route('Office.Advisor.index')->with('success', __('added successfully'));
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
        return view('Office.ProjectManagement.Advisor.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $developer = Advisor::find($id);
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('advisors')->ignore($developer->id), // Assuming you might want to ignore a given ID for uniqueness.
                'max:255' // Updated to 255, which is a common max length for emails. Adjust if needed.
            ],
            'phone' => [
                'required',
                Rule::unique('advisors')->ignore($developer->id), // Add ignore if this is an update operation.
                'max:25'
            ],
        ];
        $request->validate($rules);
        $developer->update($request->all());
        return redirect()->route('Office.Advisor.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        Advisor::find($id)->delete();
        return redirect()->route('Office.Advisor.index')->with('success', __('Deleted successfully'));
    }
}