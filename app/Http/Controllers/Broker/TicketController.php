<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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
        $settings = Setting::first();

        $tickets->transform(function ($ticket) {
            $ticket->formatted_id = "100{$ticket->id}";
            return $ticket;
        });
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

        $ticket = Ticket::findOrFail($id);
        $user=auth()->user();
       $ticketResponses = TicketResponse::where('ticket_id', $id)->get();

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
            'response_attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules for the attachment
        ]);

        $ticket = Ticket::findOrFail($ticketId);

        if ($ticket->status !== 'Waiting for customer') {
            $ticket->status = 'Waiting for technical support';
            $ticket->save();
        }

        $response = new TicketResponse();
        $response->ticket_id = $ticketId;
        $response->user_id = auth()->user()->id;
        $response->response = $request->input('response');

        if ($request->hasFile('response_attachment')) {
            $file = $request->file('response_attachment');
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;
            $file->move(public_path('Tickets/responses'), $fileName);
            $response->response_attachment = 'Tickets/responses/' . $fileName; // Save the file path without leading slash
        }



        $response->save();

        return redirect()->back()->with('success', __('Response added successfully'));
    }
    public function closeTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status = 'Closed';
        $ticket->save();

        return redirect()->back()->with('success', __('Ticket closed successfully'));
    }

}
