<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    protected $SectionService;

    public function __construct(SectionService $SectionService)
    {
        $this->SectionService = $SectionService;
    }
    public function index()
    {
        $sections = $this->SectionService->getAll();
        return view('Admin.Section.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Section.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->SectionService->create($request->all());
        return redirect()->route('Admin.Sections.index')
            ->withSuccess(__('added successfully'));
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $Section  =   $this->SectionService->getById($id);
        return view('Admin.Section.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        $this->SectionService->update($id, $request->all());
        return redirect()->route('Admin.Sections.index')
            ->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->SectionService->delete($id);
        return redirect()->route('Admin.Sections.index')
            ->withSuccess(__('Deleted successfully'));
    }
}
