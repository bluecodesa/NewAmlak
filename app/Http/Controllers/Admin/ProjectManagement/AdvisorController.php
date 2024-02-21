<?php

namespace App\Http\Controllers\Admin\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\AdvisorService;

class AdvisorController extends Controller
{
    protected $AdvisorService;

    public function __construct(AdvisorService $AdvisorService)
    {
        $this->AdvisorService = $AdvisorService;
    }
    public function index()
    {
        $developers = $this->AdvisorService->getAll();
        return view('Admin.ProjectManagement.Advisor.index', get_defined_vars());
    }

    public function destroy(string $id)
    {
        $this->AdvisorService->Delete($id);
        return redirect()->route('Admin.Advisor.index')->with('success', __('Deleted successfully'));
    }
}
