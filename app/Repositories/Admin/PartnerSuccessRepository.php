<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PartnerSuccessRepositoryInterface;
use App\Models\PartnerSuccess;

class PartnerSuccessRepository implements PartnerSuccessRepositoryInterface
{
    public function getAll()
    {
        return PartnerSuccess::all();
    }

    public function findById($id)
    {
        return PartnerSuccess::findOrFail($id);
    }

    public function create(array $data)
    {
        return PartnerSuccess::create($data);
    }

    public function update($id, array $data)
    {
        $partnerSuccess = $this->findById($id);
        $partnerSuccess->update($data);
        return $partnerSuccess;
    }

    public function delete($id)
    {
        $partnerSuccess = $this->findById($id);
        $partnerSuccess->delete();
    }
}
