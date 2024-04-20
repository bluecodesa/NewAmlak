<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\TicketTypeRepositoryInterface;
use App\Models\TicketType;

class TicketTypeRepository implements TicketTypeRepositoryInterface
{
    public function all()
    {
        return TicketType::all();
    }

    public function create(array $data)
    {
        return TicketType::create($data);
    }

    public function find(int $id)
    {
        return TicketType::find($id);
    }

    public function update(array $data, int $id)
    {
        $ticketType = TicketType::findOrFail($id);
        $ticketType->update($data);
        return $ticketType;
    }

    public function delete(int $id)
    {
        return TicketType::destroy($id);
    }
}
