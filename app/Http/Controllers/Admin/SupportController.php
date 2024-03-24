<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Services\Admin\SectionService;
use App\Services\Admin\SupportService;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    protected $SupportService;

    public function __construct(SupportService $SupportService)
    {
        $this->middleware(['role_or_permission:read-SupportTickets'])->only(['index']);
        $this->middleware(['role_or_permission:create-SupportTickets'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-SupportTickets'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-SupportTickets'])->only(['destroy']);
        $this->SupportService = $SupportService;
    }
    public function index()
    {
       // Retrieve all tickets
       $tickets = Ticket::all();
       $tickets->transform(function ($ticket) {
        $ticket->formatted_id = "100{$ticket->id}";
        return $ticket;
    });

       return view('Admin.supports.Tickets.index',  get_defined_vars());

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.supports.Ticket.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->SupportService->create($request->all());
        return redirect()->route('Admin.SupportTickets.index')
            ->withSuccess(__('added successfully'));
    }

    public function show(string $id)
    {
        //
           $ticket = Ticket::findOrFail($id);
            $user=auth()->user();
           // Load ticket responses
           $ticketResponses = TicketResponse::where('ticket_id', $id)->get();

           return view('Admin.supports.Tickets.show', get_defined_vars());
    }


    public function edit($id)
    {
        $Ticket  =   $this->SupportService->getById($id);
        return view('Admin.supports.TicketsType.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        $this->SupportService->update($id, $request->all());
        return redirect()->route('Admin.SupportTickets.index')
            ->withSuccess(__('Update successfully'));
    }

    public function addResponse(Request $request, $ticketId)
    {
        $request->validate([
            'response' => 'required|string',
        ]);


        $ticket = Ticket::findOrFail($ticketId);

        if ($ticket->status !== 'Waiting for customer') {
            $ticket->status = 'Waiting for the customer';

            $ticket->save();
        }

        $response = new TicketResponse();
        $response->ticket_id = $ticketId;
        $response->user_id = auth()->user()->id;
        $response->response = $request->input('response');
        $response->save();

        return redirect()->back()->with('success', __('Response added successfully'));
    }

    public function destroy($id)
    {
        $this->SupportService->delete($id);
        return redirect()->route('Admin.SupportTickets.index')
            ->withSuccess(__('Deleted successfully'));
    }


    public function getAllTicketTypes()
    {
        $tickets = $this->SupportService->getAll();
        return view('Admin.supports.TicketsType.index', get_defined_vars());
    }
    public function createTicketType()
    {
        return view('Admin.supports.TicketsType.create', get_defined_vars());
    }
    public function storeTicketType(Request $request)
    {
        $this->SupportService->create($request->all());
        return redirect()->route('Admin.SupportTickets.tickets-type')
            ->withSuccess(__('added successfully'));
    }

    public function editTicketType($id)
    {
        $Ticket  =   $this->SupportService->getById($id);
        return view('Admin.supports.TicketsType.edit', get_defined_vars());
    }
    public function updateTicketType(Request $request, $id)
    {
        $this->SupportService->update($id, $request->all());
        return redirect()->route('Admin.SupportTickets.tickets-type')
            ->withSuccess(__('Update successfully'));
    }
    public function destroyTicketType($id)
    {
        $this->SupportService->delete($id);
        return redirect()->route('Admin.SupportTickets.tickets-type')
            ->withSuccess(__('Deleted successfully'));
    }

    public function showInfoSupport()
    {
       // Retrieve all tickets
       $tickets = Ticket::all();

       return view('Admin.supports.Setting.index', compact('tickets'));

    }
}
