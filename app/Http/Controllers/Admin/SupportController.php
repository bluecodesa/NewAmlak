<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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
           $formatted_id = "100{$ticket->id}";
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
        // Validate the request data
        $request->validate([
            'response' => 'required|string',
            'response_attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules for the attachment

        ]);

        // Find the ticket
        $ticket = Ticket::findOrFail($ticketId);

        // Update the ticket status if necessary
        if ($ticket->status !== 'Waiting for customer') {
            $ticket->status = 'Waiting for the customer';
            $ticket->save();
        }

        // Create a new ticket response instance
        $response = new TicketResponse();
        $response->ticket_id = $ticketId;
        $response->user_id = auth()->user()->id;
        $response->response = $request->input('response');

        // Handle file upload if a file is provided
        if ($request->hasFile('response_attachment')) {
            $file = $request->file('response_attachment');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Tickets/responses'), $fileName);
            $response->response_attachment = 'Tickets/responses/' . $fileName; // Save the file path without leading slash
        }

        // Save the ticket response
        $response->save();

        // Redirect back with a success message
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
       $settings = Setting::first();

       return view('Admin.supports.Setting.index', compact('settings'));

    }

    public function updateInfoSupport(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'support_email' => ['nullable', 'email', 'max:255'],
            'support_phone' => ['nullable', 'string', 'max:255'],
        ]);

        // Retrieve the settings record
        $settings = Setting::first();

        // Update the support contact information
        $settings->update([
            'support_email' => $validatedData['support_email'],
            'support_phone' => $validatedData['support_phone'],
        ]);

        return redirect()->back()->with('success', 'Support contact information updated successfully.');
    }
    public function closeTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status = 'Closed';
        $ticket->save();

        return redirect()->back()->with('success', __('Ticket closed successfully'));
    }
}
