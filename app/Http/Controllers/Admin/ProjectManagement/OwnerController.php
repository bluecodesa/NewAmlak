<?php

namespace App\Http\Controllers\Admin\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\OwnerService;

class OwnerController extends Controller
{
    protected $OwnerService;

    public function __construct(OwnerService $OwnerService)
    {
        $this->OwnerService = $OwnerService;
    }

    public function index()
    {
        $owners =   $this->OwnerService->getAll();
        return view('Admin.ProjectManagement.Owner.index', get_defined_vars());
    }

    public function destroy(string $id)
    {
        $this->OwnerService->Delete($id);
        return redirect()->route('Admin.Owner.index')->with('success', __('Deleted successfully'));
    }
}
