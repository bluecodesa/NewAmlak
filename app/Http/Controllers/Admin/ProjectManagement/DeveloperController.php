<?php

namespace App\Http\Controllers\Admin\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\DeveloperService;

class DeveloperController extends Controller
{
    protected $DeveloperService;

    public function __construct(DeveloperService $DeveloperService)
    {
        $this->DeveloperService = $DeveloperService;
    }

    public function index()
    {
        $developers = $this->DeveloperService->getAll();
        return view('Admin.ProjectManagement.Developer.index', get_defined_vars());
    }

    public function destroy(string $id)
    {
        $this->DeveloperService->Delete($id);
        return redirect()->route('Admin.Developer.index')->with('success', __('Deleted successfully'));
    }
}
