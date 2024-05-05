<?php

namespace App\Interfaces\Broker;

use App\Models\UnitInterest;
use Illuminate\Http\Request;

interface UnitInterestRepositoryInterface
{
    public function index(Request $request);

    public function create(array $data);

    public function store(Request $request);

    public function find(string $id);

    public function update(Request $request, string $id);

    public function destroy(string $id);

    public function getFilteredUnitInterests($userId, $statusFilter, $propFilter, $unitFilter, $projectFilter, $clientFilter);
}
