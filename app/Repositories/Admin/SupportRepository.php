<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SupportRepositoryInterface;
use App\Models\Section;
use App\Models\TicketType;

class SupportRepository implements SupportRepositoryInterface
{
    public function getAll()
    {
        return TicketType::get();
    }

    public function create($data)
    {
        return TicketType::create($data);
    }

    function getById($id)
    {
        return TicketType::find($id);
    }

    public function update($id, $data)
    {
        $Section = TicketType::findOrFail($id);
        $Section->update($data);
        return $Section;
    }

    public function delete($id)
    {
        return TicketType::findOrFail($id)->delete();
    }
}
