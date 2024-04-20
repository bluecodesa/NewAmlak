<?php

namespace App\Services\Broker;

use App\Repositories\Broker\UnitInterestRepository;
use Illuminate\Http\Request;

class UnitInterestService
{
    protected $unitInterestRepository;

    public function __construct(UnitInterestRepository $unitInterestRepository)
    {
        $this->unitInterestRepository = $unitInterestRepository;
    }

    public function index(Request $request)
    {
        return $this->unitInterestRepository->index($request);
    }

    public function create(array $data)
    {
        return $this->unitInterestRepository->create($data);
    }

    public function show(string $id)
    {
        return $this->unitInterestRepository->show($id);
    }

    public function update(Request $request, string $id)
    {
        return $this->unitInterestRepository->update($request, $id);
    }

    public function destroy(string $id)
    {
        $this->unitInterestRepository->destroy($id);
    }
    public function getNumberOfInterests()
    {
        return $this->unitInterestRepository->getNumberOfInterests();
    }

    public function getUnitInterestsByUnitId($id)
    {
        return  $this->unitInterestRepository->getUnitInterestsByUnitId($id);
    }
}
