<?php

namespace App\Interfaces\Admin;

use App\Models\TicketType;

interface InterestTypeRepositoryInterface
{
    public function getAllInterestTypes();
    public function createInterestType($data);
    public function getInterestTypeById($data);
    public function updateInterestType($id, $data);
    public function deleteInterestType($id);
}
