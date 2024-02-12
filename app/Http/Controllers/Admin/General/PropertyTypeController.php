<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\PropertyType;
use App\Models\Region;
use Illuminate\Validation\Rule;

class PropertyTypeController extends Controller
{
    public function index()
    {
        $types = PropertyType::all();
        return view('Admin.settings.ProjectType.PropertyType.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.ProjectType.PropertyType.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_type_translations', 'name')]];
        }
        $request->validate($rules);
        PropertyType::create($request->all());
        return redirect()->route('Admin.PropertyType.index')->with('success', __('added successfully'));
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
        $PropertyType = PropertyType::find($id);
        return view('Admin.settings.ProjectType.PropertyType.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $PropertyType = PropertyType::find($id);
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_type_translations', 'name')->ignore($PropertyType->id, 'property_type_id')]];
        }
        $request->validate($rules);
        $PropertyType->update($request->all());
        return redirect()->route('Admin.PropertyType.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        PropertyType::find($id)->delete();
        return redirect()->route('Admin.PropertyType.index')->with('success', __('Deleted successfully'));
    }
}
