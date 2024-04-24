<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\TicketType;
use App\Models\User;
use App\Notifications\Admin\AdminResponseTicketNotification;
use App\Notifications\Admin\NewTicketNotification;
use App\Notifications\Admin\ResponseTicketNotification;
use App\Services\Admin\TicketTypeService;
use App\Services\Broker\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Services\Broker\TicketService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    protected $ticketService;
    protected $settingService;
    protected $ticketTypeService;


    public function __construct(
        TicketService $ticketService,
        SettingService $settingService,
        TicketTypeService $ticketTypeService
    ) {
        $this->ticketService = $ticketService;
        $this->settingService =  $settingService;
        $this->ticketTypeService =  $ticketTypeService;
    }

    public function index()
    {
        $tickets = $this->ticketService->getUserTickets(auth()->id());
        // $settings = Setting::first();
        $settings = $this->settingService->getSettings();
        $tickets->transform(function ($ticket) {
            $ticket->formatted_id = "100{$ticket->id}";
            return $ticket;
        });
        return view('Broker.Ticket.index', get_defined_vars());
    }

    public function create()
    {
        // $ticketTypes = TicketType::all();
        $ticketTypes = $this->ticketTypeService->getAllTicketTypes();
        return view('Broker.Ticket.create', compact('ticketTypes'));
    }

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
        $this->notifyAdmins($ticket);

        return redirect()->route('Broker.Tickets.index')->with('success', 'Ticket created successfully');
    }

    public function show(string $id)
    {
        $ticket = $this->ticketService->findTicketById($id);
        $formatted_id  = "100{$ticket->id}";
        $user = auth()->user();

        // Check if the ticket belongs to the authenticated user
        if ($ticket->user_id !== $user->id) {
            return redirect()->route('Broker.home');
        }

        $ticketResponses = $this->ticketService->getTicketResponses($id);

        $url = URL::current();
        if (isset(auth()->user()->unreadNotifications)) {
            $notifications = auth()->user()->unreadNotifications
                ->filter(function ($notification) use ($url) {
                    return data_get($notification->data, 'url') == $url;
                });
            $notifications->each(function ($notification) {
                $notification->markAsRead();
            });
        }

        return view('Broker.Ticket.show', get_defined_vars());
    }

    public function addResponse(Request $request, $ticketId)
    {
        $ticketData = [
            'user_id' => auth()->user()->id,
            'response' => $request->input('response'),
            'response_attachment' => $request->file('response_attachment'),
        ];

        $this->ticketService->addResponseToTicket($ticketId, $ticketData);

        return redirect()->back()->with('success', __('Response added successfully'));
    }


    public function closeTicket(Request $request, $id)
    {
        $this->ticketService->closeTicket($id);
        return redirect()->back()->with('success', __('Ticket closed successfully'));
    }

    protected function notifyAdmins(Ticket $ticket)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewTicketNotification($ticket));
        }
    }
}
