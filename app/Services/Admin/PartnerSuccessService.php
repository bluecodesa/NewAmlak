<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\PartnerSuccessRepositoryInterface;
use Illuminate\Support\Facades\File;

class PartnerSuccessService
{
    protected $repository;

    public function __construct(PartnerSuccessRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        if (isset($data['image']) && $data['image']->isValid()) {
            $file = $data['image'];
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/Admin/PartnerSuccess/Images/'), $filename);
            $data['image'] = '/Admin/PartnerSuccess/Images/' . $filename;
        }

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $partnerSuccess = $this->findById($id);

        if (isset($data['image']) && $data['image']->isValid()) {
            if ($partnerSuccess->image && File::exists(public_path($partnerSuccess->image))) {
                File::delete(public_path($partnerSuccess->image));
            }

            $file = $data['image'];
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/Admin/PartnerSuccess/Images/'), $filename);
            $data['image'] = '/Admin/PartnerSuccess/Images/' . $filename;
        }

        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        $partnerSuccess = $this->findById($id);

        if ($partnerSuccess->image && File::exists(public_path($partnerSuccess->image))) {
            File::delete(public_path($partnerSuccess->image));
        }

        return $this->repository->delete($id);
    }
}
