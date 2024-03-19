<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\GalleryRepositoryInterface;
use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Models\Broker;
use App\Models\Unit;
use App\Models\User;

class GalleryService
{
    protected $galleryRepository;
    protected $UnitRepository;


    public function __construct(UnitRepositoryInterface $UnitRepository,GalleryRepositoryInterface $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
        $this->UnitRepository = $UnitRepository;

    }


    public function all()
    {
        return $this->galleryRepository->all();
    }

    public function findById($galleryId)
    {
        return $this->galleryRepository->findById($galleryId);
    }

    public function create(array $data)
    {

        return $this->galleryRepository->create($data);
    }

    public function update(array $data, $galleryId)
    {
        $request=request();
        $data = $request->validate([
            'gallery_name' => 'required|string|unique:galleries|max:255',
            'gallery_status' => 'nullable|in:0,1',
        ]);
        $messages = [
            'gallery_name.required' => __('The gallery_name field is required.'),
            'gallery_name.unique' => __('The gallery_name has already been taken.'),
        ];
        validator($data, $messages)->validate();

        $gallery = $this->galleryRepository->findById($galleryId);

        $gallery->update([
            'gallery_name' => $data['gallery_name'],
            'gallery_status' => $request->has('gallery_status') ? '1' : '0',
        ]);

        return $this->galleryRepository->update($data, $galleryId);

    }

    public function delete($galleryId)
    {
        return $this->galleryRepository->delete($galleryId);
    }

    public function findByBrokerId($brokerId)
    {
        return $this->galleryRepository->findByBrokerId($brokerId);
    }



    public function updateCover(array $data)
    {
        $request=request();
        $data=$request->validate([
            'gallery_id' => 'required',
            'gallery_cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return $this->galleryRepository->updateCover($data);
    }


    public function showUnitPublic($galleryName, $id)
    {
        $gallery = $this->galleryRepository->findByGalleryName($galleryName);

        if ($gallery->gallery_status == 0) {
            return [];
        }

        $units = $this->UnitRepository->getAll($gallery['broker_id']);
        $Unit = $this->UnitRepository->findById($id);
        if (!$Unit) {
            abort(404);
        }

        $gallery = $this->galleryRepository->findByBrokerId($gallery->broker_id);

        $broker=Broker::findOrFail($Unit->broker_id);
        $brokers=User::findOrFail($broker->user_id);
        $unit_id=$Unit->id;
        $user_id=$broker->user_id;

        return get_defined_vars();
    }

    public function showByName($name)
    {
        $gallery = $this->galleryRepository->findByGalleryName($name);
        if ($gallery->gallery_status == 0) {
            return [];
        }else{

        $units = $this->UnitRepository->getAll($gallery['broker_id']);

        $unit = $units->first();
        $id = $unit ? $unit->id : null;

        $unitDetails = $id ? $this->galleryRepository->findById($id) : null;

        $unit_id=$unit->id;

        $broker=Broker::findOrFail($unit->broker_id);
        $user_id=$broker->user_id;
        return get_defined_vars();
    }
    }

    public function filterUnits($units, $adTypeFilter, $typeUseFilter, $cityFilter)
    {
        if ($adTypeFilter !== 'all') {
            $units = $units->where('type', $adTypeFilter);
        }

        if ($typeUseFilter !== 'all') {
            $units = $units->where('type_use', $typeUseFilter);
        }

        if (!is_null($cityFilter)) {
            $units = $units->where('city_id', $cityFilter);
        }

        return $units;
    }



}
