<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\PropertyUsage;
use App\Models\Region;
use Illuminate\Validation\Rule;

class PropertyUsageController extends Controller
{
    public function index()
    {
        $types = PropertyUsage::all();
        return view('Admin.settings.ProjectType.PropertyUsage.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.ProjectType.PropertyUsage.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_usage_translations', 'name')]];
        }
        $request->validate($rules);
        PropertyUsage::create($request->all());
        return redirect()->route('Admin.PropertyUsage.index')->with('success', __('added successfully'));
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
        $PropertyUsage = PropertyUsage::find($id);
        return view('Admin.settings.ProjectType.PropertyUsage.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $PropertyUsage = PropertyUsage::find($id);
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_usage_translations', 'name')->ignore($PropertyUsage->id, 'property_usage_id')]];
        }
        $request->validate($rules);
        $PropertyUsage->update($request->all());
        return redirect()->route('Admin.PropertyUsage.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        PropertyUsage::find($id)->delete();
        return redirect()->route('Admin.PropertyUsage.index')->with('success', __('Deleted successfully'));
    }
}
