<?php


namespace App\Interfaces\Broker;

use App\Models\Ticket;

interface TicketRepositoryInterface
{
    public function getAll();

    public function getUserTickets(int $userId);

    public function findTicketById(int $ticketId);

    public function createTicket(array $ticketData);

    public function addResponseToTicket(int $ticketId, array $responseData);

    public function closeTicket(int $ticketId);
    public function getTicketResponses(int $ticketId);

}
