<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\VisitorRepositoryInterface;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class VisitorService
{
    protected $visitorRepository;

    public function __construct(VisitorRepositoryInterface $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function getAllVisitor()
    {
        return $this->visitorRepository->all();
    }

    public function createVisitor(array $data)
    {

        return $this->visitorRepository->create($data);
    }

    public function findVisitor(int $id)
    {
        return $this->visitorRepository->find($id);
    }

    public function updateVisitor(array $data, int $id)
    {
        return $this->visitorRepository->update($id,$data);
    }

    public function deleteVisitor(int $id)
    {
        return $this->visitorRepository->delete($id);
    }

    public function findVisitorByUnitAndIP(int $unitId, string $ipAddress)
    {
        return Visitor::where('unit_id', $unitId)
            ->where('ip_address', $ipAddress)
            ->where('visited_at', '>=', now()->subHour())
            ->first();
    }

    public function findVisitorByGalleryAndIP(int $galleryId, string $ipAddress)
    {
        return Visitor::where('gallery_id', $galleryId)
            ->where('ip_address', $ipAddress)
            ->where('visited_at', '>=', now()->subHour())
            ->first();
    }

    public function getUnitVisitorCount(int $unitId)
    {
        return Visitor::where('unit_id', $unitId)->count();
    }
}
