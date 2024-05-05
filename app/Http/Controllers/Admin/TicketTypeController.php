<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\TicketTypeService;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{

    protected $ticketTypeService;

    public function __construct(TicketTypeService $ticketTypeService)
    {
        $this->middleware(['role_or_permission:create-support-ticket-type'])->only(['create', 'store']);
        $this->middleware(['role_or_permission:update-support-ticket-type'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-support-ticket-type'])->only(['destroy']);

        $this->ticketTypeService = $ticketTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tickets = $this->ticketTypeService->getAllTicketTypes();
        return view('Admin.supports.TicketsType.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.supports.TicketsType.create', get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->ticketTypeService->createTicketType($request->all());
        return redirect()->route('Admin.TicketTypes.index')
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
        $Ticket  =   $this->ticketTypeService->findTicketType($id);
        return view('Admin.supports.TicketsType.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->ticketTypeService->updateTicketType($request->all(),$id);
        return redirect()->route('Admin.TicketTypes.index')
            ->withSuccess(__('Update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->ticketTypeService->deleteTicketType($id);
        return redirect()->route('Admin.TicketTypes.index')
            ->withSuccess(__('Deleted successfully'));
    }
}
