<?php

namespace App\Http\Controllers\Admin\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    protected $ProjectService;


    public function __construct(
        ProjectService $ProjectService,

    ) {
        // $this->middleware(['role_or_permission:read-support-ticket-admin'])->only(['index']);
        // $this->middleware(['role_or_permission:create-SupportTickets'])->only(['store', 'create']);
        // $this->middleware(['role_or_permission:update-SupportTickets'])->only(['edit', 'update']);
        // $this->middleware(['role_or_permission:delete-support-ticket-admin'])->only(['destroy']);

        // $this->middleware(['role_or_permission:create-support-ticket-type'])->only(['createTicketType', 'storeTicketType']);
        // $this->middleware(['role_or_permission:update-support-ticket-type'])->only(['editTicketType', 'updateTicketType']);
        // $this->middleware(['role_or_permission:delete-support-ticket-type'])->only(['destroyTicketType']);

        $this->ProjectService = $ProjectService;

    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $projectStatus = $this->ProjectService->getAllProjectStatus();
        $deliveryCases = $this->ProjectService->getAllDeliveryCases();

        return view('Admin.settings.ProjectSettings.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.settings.ProjectSettings.inc._createProjectStatus',get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->ProjectService->createProjectStatu($request->all());
        return redirect()->route('Admin.ProjectSettings.index')
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
    public function edit(string $id)
    {
        //
        $ProjectStatu  =   $this->ProjectService->getProjectStatuById($id);
        return view('Admin.supports.TicketsType.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->ProjectService->updateProjectStatu($id, $request->all());
        return redirect()->route('Admin.Admin.ProjectSettings.index')
            ->withSuccess(__('Update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->ProjectService->deleteProjectStatus($id);
        return redirect()->route('Admin.ProjectSettings.index')
            ->withSuccess(__('Deleted successfully'));
    }


    //delivery cases
    public function getAllDeliveryCases()
    {
        $deliveryCases = $this->ProjectService->getAllDeliveryCases();
        return view('Admin.supports.TicketsType.index', get_defined_vars());
    }
    public function createDeliveryCase()
    {
        return view('Admin.settings.ProjectSettings.inc._createDeliveryCase',get_defined_vars());
    }
    public function storeDeliveryCase(Request $request)
    {
        $this->ProjectService->createDeliveryCase($request->all());
        return redirect()->route('Admin.SupportTickets.tickets-type')
            ->withSuccess(__('added successfully'));
    }

    public function editDeliveryCase($id)
    {
        $Ticket  =   $this->ProjectService->getDeliveryCaseById($id);
        return view('Admin.settings.ProjectSettings.inc._editDeliveryCase',get_defined_vars());
    }
    public function updateDeliveryCase(Request $request, $id)
    {
        $this->ProjectService->updateDeliveryCase($id, $request->all());
        return redirect()->route('Admin.SupportTickets.tickets-type')
            ->withSuccess(__('Update successfully'));
    }
    public function deleteDeliveryCase($id)
    {
        $this->ProjectService->deleteDeliveryCase($id);
        return redirect()->route('Admin.SupportTickets.tickets-type')
            ->withSuccess(__('Deleted successfully'));
    }

}
