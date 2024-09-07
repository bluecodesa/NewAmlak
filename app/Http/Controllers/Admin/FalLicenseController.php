<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FalLicenseService;
use Illuminate\Http\Request;

class FalLicenseController extends Controller
{


    protected $FalLicenseService;

    public function __construct(FalLicenseService $FalLicenseService)
    {
        $this->middleware(['role_or_permission:read-sections'])->only(['index']);
        $this->middleware(['role_or_permission:create-sections'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-sections'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-sections'])->only(['destroy']);
        $this->FalLicenseService = $FalLicenseService;
    }

    public function index()
    {
        $falLicenses = $this->FalLicenseService->getAll();
        return view('Admin.settings.FalLicense.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.FalLicense.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->FalLicenseService->create($request->all());
        return redirect()->route('Admin.FalLicense.index')
            ->withSuccess(__('added successfully'));
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $falLicense  =   $this->FalLicenseService->getById($id);
        return view('Admin.settings.FalLicense.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        $this->FalLicenseService->update($id, $request->all());
        return redirect()->route('Admin.FalLicense.index')
            ->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->FalLicenseService->delete($id);
        return redirect()->route('Admin.FalLicense.index')
            ->withSuccess(__('Deleted successfully'));
    }
}
