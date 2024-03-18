<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
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
        $tickets = Ticket::where('broker_id', auth()->user()->id)->get();

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
            $imagePath = $request->file('image')->store('images', 'public'); // Store the image in the 'public' disk under the 'images' directory
            $validatedData['image'] = $imagePath;
        }

        // Create a new ticket instance
        $ticket = new Ticket();
        $user = auth()->user();

        if ($user->is_broker) {
            // If the user is a broker, set the broker_id
            $ticket->broker_id = $user->id;
        } elseif ($user->is_office) {
            // If the user is an office, set the office_id
            $ticket->office_id = $user->id; // Assuming the office ID is the user ID
        }
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
        return view('Broker.Ticket.show', compact('ticket'));
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
}
