<?php

namespace App\Interfaces\Admin;

use App\Models\TicketType;

interface TicketTypeRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find(int $id);

    public function update(array $data, int $id);

    public function delete(int $id);
}
