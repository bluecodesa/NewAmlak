<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SupportRepositoryInterface;
use App\Models\Section;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\TicketType;

class SupportRepository implements SupportRepositoryInterface
{
    public function getAllTicketTypes()
    {
        return TicketType::paginate(100);
    }

    public function createTicketType($data)
    {
        return TicketType::create($data);
    }

    function getTicketTypById($id)
    {
        return TicketType::find($id);
    }

    function getTicketResponseById($id)
    {
        return  TicketResponse::where('ticket_id', $id)->get();

    }

    public function updateTicketType($id, $data)
    {
        $Section = TicketType::findOrFail($id);
        $Section->update($data);
        return $Section;
    }

    public function deleteTicket($id)
    {
        return Ticket::findOrFail($id)->delete();
    }

    public function deleteTicketType($id)
    {
        return TicketType::findOrFail($id)->delete();
    }

    public function createTicketResponse(TicketResponse $response)
    {
        return $response->save();
    }

    public function findTicketById(int $ticketId)
    {
        return Ticket::findOrFail($ticketId);
    }
    public function closeTicket(int $ticketId)
    {
        $ticket = $this->findTicketById($ticketId);
        $ticket->status = 'Closed';
        $ticket->save();
    }
}
