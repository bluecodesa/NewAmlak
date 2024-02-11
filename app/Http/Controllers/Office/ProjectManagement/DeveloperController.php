<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Developer;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DeveloperController extends Controller
{
    public function index()
    {
        $developers = Developer::where('office_id', Auth::user()->UserOfficeData->id)->get();
        return view('Office.ProjectManagement.Developer.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        return view('Office.ProjectManagement.Developer.create', get_defined_vars());
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
                Rule::unique('developers')->ignore($request->id), // Assuming you might want to ignore a given ID for uniqueness.
                'max:255' // Updated to 255, which is a common max length for emails. Adjust if needed.
            ],
            'phone' => [
                'required',
                Rule::unique('developers')->ignore($request->id), // Add ignore if this is an update operation.
                'max:25'
            ],
        ];
        $request_data = $request->all();
        $request_data['office_id'] = Auth::user()->UserOfficeData->id;
        $request->validate($rules);
        Developer::create($request_data);
        return redirect()->route('Office.Developer.index')->with('success', __('added successfully'));
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
        $developer = Developer::find($id);
        $cities = City::all();
        return view('Office.ProjectManagement.Developer.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $developer = Developer::find($id);
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('developers')->ignore($developer->id), // Assuming you might want to ignore a given ID for uniqueness.
                'max:255' // Updated to 255, which is a common max length for emails. Adjust if needed.
            ],
            'phone' => [
                'required',
                Rule::unique('developers')->ignore($developer->id), // Add ignore if this is an update operation.
                'max:25'
            ],
        ];
        $request->validate($rules);
        $developer->update($request->all());
        return redirect()->route('Office.Developer.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        Developer::find($id)->delete();
        return redirect()->route('Office.Developer.index')->with('success', __('Deleted successfully'));
    }
}
