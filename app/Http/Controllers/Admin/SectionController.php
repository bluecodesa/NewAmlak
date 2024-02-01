<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class SectionController extends Controller
{

    public function index()
    {
        $sections = Section::get();
        return view('Admin.section.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.section.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('section_translations', 'name')]];
        }
        $request->validate($rules);
        Section::create($request->all());

        return redirect()->route('Admin.Sections.index')
            ->withSuccess(__('added successfully'));
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
    public function edit(Section $Section)
    {
        return view('Admin.section.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $Section)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('section_translations', 'name')->ignore($Section->id, 'section_id')]];
        }
        $request->validate($rules);
        $Section->update($request->all());
        return redirect()->route('Admin.Sections.index')
            ->withSuccess(__('Update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $Section)
    {
        $Section->delete();
        return redirect()->route('Admin.Sections.index')
            ->withSuccess(__('Deleted successfully'));
    }
}