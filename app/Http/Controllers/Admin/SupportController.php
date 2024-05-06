<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use App\Notifications\Admin\AdminResponseTicketNotification;
use App\Notifications\Admin\ResponseTicketNotification;
use App\Services\Admin\SectionService;
use App\Services\Admin\SettingService;
use App\Services\Admin\SupportService;
use App\Services\Broker\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SupportController extends Controller
{
    protected $SupportService;
    protected $ticketService;
    protected $settingService;




    public function __construct(
        SupportService $SupportService,
        TicketService $ticketService,
        SettingService $settingService
    ) {
        $this->middleware(['role_or_permission:read-support-ticket-admin'])->only(['index', 'show']);
        $this->middleware(['role_or_permission:create-SupportTickets'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-SupportTickets'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-support-ticket-admin'])->only(['destroy']);


        $this->SupportService = $SupportService;
        $this->ticketService = $ticketService;

        $this->settingService = $settingService;
    }
    public function index()
    {
        //    $tickets = Ticket::all();
        $tickets = $this->ticketService->getAllTickets();
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

    }

    public function show(string $id)
    {
        //
        //    $ticket = Ticket::findOrFail($id);
        $ticket = $this->ticketService->findTicketById($id);
        $formatted_id = "100{$ticket->id}";
        $user = auth()->user();
        // Load ticket responses
        $ticketResponses = TicketResponse::where('ticket_id', $id)->get();
        return view('Admin.supports.Tickets.show', get_defined_vars());
    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function addResponse(Request $request, $ticketId)
    {
        // Validate the request data
        $request->validate([
            'response' => 'required|string',
            'response_attachment' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'response_attachment.mimes' => 'The response attachment must be a valid image (jpg, jpeg, png, gif) or PDF file.',
            'response_attachment.max' => 'The response attachment may not be greater than :max kilobytes.',
        ]);

        $response = $this->SupportService->addResponse($request->all(), $ticketId);

        return redirect()->back()->with('success', __('Response added successfully'));
    }


    public function closeTicket(Request $request, $id)
    {
        $this->SupportService->closeTicket($id);
        return redirect()->back()->with('success', __('Ticket closed successfully'));
    }


    public function destroy($id)
    {
        $this->SupportService->deleteTicket($id);
        return redirect()->route('Admin.SupportTickets.index')
            ->withSuccess(__('Deleted successfully'));
    }





    // InfoSupport

    public function showInfoSupport()
    {

        // Retrieve all tickets
        //    $settings = Setting::first();
        $settings = $this->settingService->getFirstSetting();

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
        $settings = $this->settingService->getFirstSetting();

        // Update the support contact information
        $settings->update([
            'support_email' => $validatedData['support_email'],
            'support_phone' => $validatedData['support_phone'],
        ]);

        return redirect()->back()->with('success', 'Support contact information updated successfully.');
    }
}
