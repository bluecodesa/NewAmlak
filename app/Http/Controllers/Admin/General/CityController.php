<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Region;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index()
    {
        $Cities = City::all();
        return view('Admin.settings.Region.City.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        return view('Admin.settings.Region.City.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('city_translations', 'name')]];
        }
        $request->validate($rules);
        City::create($request->all());
        return redirect()->route('Admin.City.index')->with('success', __('added successfully'));
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

        $City = City::find($id);
        return view('Admin.settings.Region.City.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $City = City::find($id);
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('city_translations', 'name')->ignore($City->id, 'city_id')]];
        }
        $request->validate($rules);
        $City->update($request->all());
        return redirect()->route('Admin.City.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        City::find($id)->delete();
        return redirect()->route('Admin.City.index')->with('success', __('Deleted successfully'));
    }
}
