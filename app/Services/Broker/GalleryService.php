<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\GalleryRepositoryInterface;
use App\Interfaces\Broker\UnitRepositoryInterface;


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
            'gallery_name' => 'required|string|max:255',
            'gallery_status' => 'nullable|in:0,1',
        ]);
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
            abort(404);
        }

        $units = $this->UnitRepository->getAll($gallery['broker_id']);
        $Unit = $this->UnitRepository->findById($id);
        if (!$Unit) {
            abort(404);
        }

        $units = $this->galleryRepository->findByBrokerId($gallery->broker_id);

        return ['gallery' => $gallery, 'Unit' => $Unit, 'units' => $units];
    }

    public function showByName($name)
    {
        $gallery = $this->galleryRepository->findByGalleryName($name);

        if ($gallery->gallery_status == 0) {
            abort(404);
        }

        $units = $this->UnitRepository->getAll($gallery['broker_id']);

        $unit = $units->first();
        $id = $unit->id;
        $unitDetails = $this->galleryRepository->findById($id);

        return ['gallery' => $gallery,'units' => $units, 'unit' => $unit, 'unitDetails' => $unitDetails];
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
