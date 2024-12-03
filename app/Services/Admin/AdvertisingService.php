<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\AdvertisingRepositoryInterface;
use App\Models\Advertising;
use Carbon\Carbon;

class AdvertisingService
{
    protected $repository;

    public function __construct(AdvertisingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        $ads = $this->repository->getAll();
        $today = Carbon::today();

        Advertising::where('show_end_date', '<', $today)
            ->where('status', '!=', 'Finished')
            ->update(['status' => 'Finished']);

        Advertising::where('show_start_date', '<=', $today)
            ->whereNotIn('status', ['Published', 'Finished'])
            ->update(['status' => 'Published']);

        return $ads;
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        if (isset($data['content']) && $data['content']->isValid()) {
            $file = $data['content'];
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/Admin/Advertisings/Files/'), $filename);
            $data['content'] = '/Admin/Advertisings/Files/' . $filename;
        }

        $data['status'] = (new Carbon($data['show_start_date']))->isToday() ? 'Published' : 'Scheduled';

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        if (isset($data['content']) && $data['content']->isValid()) {
            $file = $data['content'];
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/Admin/Advertisings/Files/'), $filename);
            $data['content'] = '/Admin/Advertisings/Files/' . $filename;
        }

        $data['status'] = (new Carbon($data['show_start_date']))->isToday() ? 'Published' : 'Scheduled';

        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
