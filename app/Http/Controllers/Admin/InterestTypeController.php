<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\InterestTypeService;
use Illuminate\Http\Request;

class InterestTypeController extends Controller
{
    protected $interestTypeService;

    public function __construct(InterestTypeService $interestTypeService)
    {
        $this->middleware(['role_or_permission:create-interest-request-status'])->only(['create', 'store']);
        $this->middleware(['role_or_permission:update-interest-request-status'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-interest-request-status'])->only(['destroy']);

        $this->interestTypeService = $interestTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.settings.InterestType.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->interestTypeService->createInterestType($request->all());

        return redirect()->route('Admin.settings.index')->withSuccess(__('added successfully'));
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
    public function edit(string $id)
    {
        //
        $Interest  =   $this->interestTypeService->getInterestTypeById($id);
        return view('Admin.settings.InterestType.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->interestTypeService->updateInterestType($id, $request->all());
        return redirect()->route('Admin.settings.index')
            ->withSuccess(__('Update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->interestTypeService->deleteInterestType($id);
        return redirect()->route('Admin.settings.index')
            ->withSuccess(__('Deleted successfully'));
    }
}
