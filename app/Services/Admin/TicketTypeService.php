<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\TicketTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TicketTypeService
{
    protected $ticketTypeRepository;

    public function __construct(TicketTypeRepositoryInterface $ticketTypeRepository)
    {
        $this->ticketTypeRepository = $ticketTypeRepository;
    }

    public function getAllTicketTypes()
    {
        return $this->ticketTypeRepository->all();
    }

    public function createTicketType(array $data)
    {
        // You can add validation logic here if needed
        return $this->ticketTypeRepository->create($data);
    }

    public function findTicketType(int $id)
    {
        return $this->ticketTypeRepository->find($id);
    }

    public function updateTicketType(array $data, int $id)
    {
        // You can add validation logic here if needed
        return $this->ticketTypeRepository->update($data, $id);
    }

    public function deleteTicketType(int $id)
    {
        return $this->ticketTypeRepository->delete($id);
    }
}
