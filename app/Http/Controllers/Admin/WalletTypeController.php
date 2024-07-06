<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\WalletTypeService;
use Illuminate\Http\Request;

class WalletTypeController extends Controller
{

    protected $WalletTypeService;

    public function __construct(WalletTypeService $WalletTypeService)
    {
        $this->middleware(['role_or_permission:read-sections'])->only(['index']);
        $this->middleware(['role_or_permission:create-sections'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-sections'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-sections'])->only(['destroy']);
        $this->WalletTypeService = $WalletTypeService;
    }

    public function index()
    {
        $walletTypes = $this->WalletTypeService->getAll();
        return view('Admin.Wallet.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Wallet.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->WalletTypeService->create($request->all());
        return redirect()->route('Admin.WalletTypes.index')
            ->withSuccess(__('added successfully'));
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $Wallet  =   $this->WalletTypeService->getById($id);
        return view('Admin.Wallet.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        $this->WalletTypeService->update($id, $request->all());
        return redirect()->route('Admin.WalletTypes.index')
            ->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->WalletTypeService->delete($id);
        return redirect()->route('Admin.WalletTypes.index')
            ->withSuccess(__('Deleted successfully'));
    }
}
