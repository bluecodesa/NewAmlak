<?php
// app/Services/TicketService.php

namespace App\Services\Office;

use App\Interfaces\Broker\TicketRepositoryInterface;
use App\Models\TicketResponse;
use App\Models\User;
use App\Notifications\Admin\AdminResponseTicketNotification;
use Illuminate\Support\Facades\Notification;

class TicketService
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getAllTickets()
    {
        return $this->ticketRepository->getAll();
    }
    public function getUserTickets(int $userId)
    {
        return $this->ticketRepository->getUserTickets($userId);
    }

    public function findTicketById(int $ticketId)
    {
        return $this->ticketRepository->findTicketById($ticketId);
    }

    public function createTicket(array $ticketData)
    {
        return $this->ticketRepository->createTicket($ticketData);
    }

    public function addResponseToTicket(int $ticketId, array $responseData)
    {
        $this->ticketRepository->addResponseToTicket($ticketId, $responseData);

        // Send notification to admins
        $response = new TicketResponse();
        $response->ticket_id = $ticketId;
        $response->user_id = $responseData['user_id'];
        $response->response = $responseData['response'];
        $response->response_attachment = $responseData['response_attachment'] ?? null;

        $this->notifyAdmins($response);
    }

    protected function notifyAdmins(TicketResponse $response)
    {
        // Retrieve all admins
        $admins = User::where('is_admin', true)->get();

        // Send notification to each admin
        foreach ($admins as $admin) {
            Notification::send($admin, new AdminResponseTicketNotification($response));
        }
    }

    public function closeTicket(int $ticketId)
    {
        return $this->ticketRepository->closeTicket($ticketId);
    }

    public function getTicketResponses(string $ticketId)
    {
        return $this->ticketRepository->getTicketResponses($ticketId);
    }
}
