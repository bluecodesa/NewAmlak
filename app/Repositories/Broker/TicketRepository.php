<?php

namespace App\Repositories\Broker;

use App\Models\Ticket;
use App\Interfaces\Broker\TicketRepositoryInterface;
use App\Models\TicketResponse;

class TicketRepository implements TicketRepositoryInterface
{
    public function getUserTickets(int $userId)
    {
        return Ticket::where('user_id', $userId)->get();
    }

    public function findTicketById(int $ticketId)
    {
        return Ticket::findOrFail($ticketId);
    }

    public function createTicket(array $ticketData)
    {
        return Ticket::create($ticketData);
    }

    public function addResponseToTicket(int $ticketId, array $responseData)
    {
        $ticket = $this->findTicketById($ticketId);
        $response = new TicketResponse();
        $response->ticket_id = $ticketId;
        $response->user_id = $responseData['user_id'];
        $response->response = $responseData['response'];

        if (isset($responseData['response_attachment'])) {
            $file = $responseData['response_attachment'];
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('Tickets/responses', $fileName);
            $response->response_attachment = 'Tickets/responses/' . $fileName;
        }

        $response->save();
    }    

    public function closeTicket(int $ticketId)
    {
        $ticket = $this->findTicketById($ticketId);
        $ticket->status = 'Closed';
        $ticket->save();
    }

    public function getTicketResponses(int $ticketId)
    {
        return TicketResponse::where('ticket_id', $ticketId)->get();
    }
}
