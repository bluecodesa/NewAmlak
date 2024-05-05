<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SupportRepositoryInterface;
use App\Models\TicketResponse;
use App\Models\User;
use App\Notifications\Admin\ResponseTicketNotification;
use App\Interfaces\Broker\TicketRepositoryInterface;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupportService
{
    protected $SupportRepository;
    protected $ticketRepository;


    public function __construct(SupportRepositoryInterface $SupportRepository,TicketRepositoryInterface $ticketRepository)
    {
        $this->SupportRepository = $SupportRepository;
        $this->ticketRepository = $ticketRepository;



    }

    public function addResponse(array $data, int $ticketId)
    {
        $ticket = $this->ticketRepository->findTicketById($ticketId);

        if ($ticket->status !== 'Waiting for customer') {
            $ticket->status = 'Waiting for the customer';
            $ticket->save();
        }

        $response = new TicketResponse();
        $response->ticket_id = $ticketId;
        $response->user_id = Auth::id();
        $response->response = $data['response'];

        if (isset($data['response_attachment'])) {
            $file = $data['response_attachment'];
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Tickets/responses'), $fileName);
            $response->response_attachment = 'Tickets/responses/' . $fileName;
        }

        $this->SupportRepository->createTicketResponse($response);
        $this->notifyBroker($response);

        return $response;
    }

    protected function notifyBroker(TicketResponse $response)
    {
        $brokers = User::where('is_broker', true)->get();
        foreach ($brokers as $broker) {
            Notification::send($broker, new ResponseTicketNotification($response));
        }
    }


    public function closeTicket(int $ticketId)
    {
        return $this->ticketRepository->closeTicket($ticketId);
    }

    public function deleteTicket($id)
    {
        return $this->SupportRepository->deleteTicket($id);
    }


}
