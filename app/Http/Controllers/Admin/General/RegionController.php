<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Region;
use Illuminate\Validation\Rule;

class RegionController extends Controller
{

    public function index()
    {
        $regions = Region::all();
        return view('Admin.settings.Region.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.Region.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('region_translations', 'name')]];
        }
        $request->validate($rules);

        $request->validate($rules);
        Region::create($request->all());
        return redirect()->route('Admin.Region.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cities = City::where('region_id', $id)->get();
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }

    public function edit($id)
    {
        $Region = Region::find($id);
        return view('Admin.settings.Region.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $Region = Region::find($id);
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('region_translations', 'name')->ignore($Region->id, 'region_id')]];
        }
        $request->validate($rules);
        $Region->update($request->all());
        return redirect()->route('Admin.Region.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        Region::find($id)->delete();
        return redirect()->route('Admin.Region.index')->with('success', __('Deleted successfully'));
    }
}
