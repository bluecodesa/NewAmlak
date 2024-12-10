<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProviderServiceService;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{

    protected $ProviderServiceService;

    public function __construct(ProviderServiceService $ProviderServiceService)
    {
        $this->middleware(['role_or_permission:read-sections'])->only(['index']);
        $this->middleware(['role_or_permission:create-sections'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-sections'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-sections'])->only(['destroy']);
        $this->ProviderServiceService = $ProviderServiceService;
    }

    public function index()
    {
        $walletTypes = $this->ProviderServiceService->getAll();
        return view('Admin.ProviderService.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.ProviderService.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->ProviderServiceService->create($request->all());
        return redirect()->route('Admin.ProviderServices.index')
            ->withSuccess(__('added successfully'));
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $Wallet  =   $this->ProviderServiceService->getById($id);
        return view('Admin.ProviderService.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        $this->ProviderServiceService->update($id, $request->all());
        return redirect()->route('Admin.ProviderServices.index')
            ->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->ProviderServiceService->delete($id);
        return redirect()->route('Admin.ProviderServices.index')
            ->withSuccess(__('Deleted successfully'));
    }
}
