<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Region;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();
        return view('Admin.settings.Region.City.District.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return view('Admin.settings.Region.City.District.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('district_translations', 'name')]];
        }
        $request->validate($rules);
        District::create($request->all());
        return redirect()->route('Admin.District.index')->with('success', __('added successfully'));
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
        $cities = City::all();

        $District = District::find($id);
        return view('Admin.settings.Region.City.District.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $District = District::find($id);
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('district_translations', 'name')->ignore($District->id, 'district_id')]];
        }
        $request->validate($rules);
        $District->update($request->all());
        return redirect()->route('Admin.District.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        District::find($id)->delete();
        return redirect()->route('Admin.District.index')->with('success', __('Deleted successfully'));
    }
}
