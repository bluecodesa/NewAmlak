<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user_id = auth()->user()->id;
        $tickets = Ticket::where('user_id', $user_id)->get();

        return view ('Broker.Ticket.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $ticketTypes=TicketType::all();
        return view ('Broker.Ticket.create',get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         // Validate the form data
         $validatedData = $request->validate([
            'type' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
        ]);

        // Handle file upload if an image is provided

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;
            $file->move(public_path('Brokers/Tickets'), $fileName);
            $validatedData['image'] = '/Brokers/Tickets/' . $fileName;
        }

        // Create a new ticket instance
        $ticket = new Ticket();
        $user_id = auth()->user()->id;
        $ticket->user_id = $user_id;

        $ticket->subject = $validatedData['subject'];
        $ticket->content = $validatedData['content'];
        $ticket->image = $validatedData['image'] ?? null; // If no image provided, set to null
        $ticket->ticket_type_id = $validatedData['type'];
        $ticket->save();

        return redirect()->route('Broker.Tickets.index')->with('success', 'Ticket created successfully');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $ticket = Ticket::findOrFail($id);

        $userId =auth()->user()->id;

        $ticketResponses = $ticket->ticketResponses()->where('user_id', $userId)->get();


        return view('Broker.Ticket.show',get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addResponse(Request $request, $ticketId)
    {
        $request->validate([
            'response' => 'required|string',
        ]);


        $ticket = Ticket::findOrFail($ticketId);

        // Check if the current status is different from 'Waiting for the customer'
        if ($ticket->status !== 'Waiting for the customer') {
            // Update the status to 'Waiting for the customer'
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
    public function closeTicket(Request $request, $id)
    {
        // Find the ticket by ID
        $ticket = Ticket::findOrFail($id);

        // Update the ticket status to 'closed'
        $ticket->status = 'Closed';
        $ticket->save();

        // Redirect back or to any other page as needed
        return redirect()->back()->with('success', __('Ticket closed successfully'));
    }

}
