<?php

namespace App\Interfaces\Admin;
use App\Models\TicketResponse;


interface SupportRepositoryInterface
{
    public function getAllTicketTypes();
    public function createTicketType($data);
    public function getTicketTypById($data);
    public function updateTicketType($id, $data);
    public function deleteTicketType($id);


    public function createTicketResponse(TicketResponse $response);
    public function closeTicket(int $ticketId);
    public function deleteTicket($id);
    public function getTicketResponseById($data);


}
