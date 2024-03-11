<?php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\GalleryRepositoryInterface;
use App\Models\Gallery;

class GalleryRepository implements GalleryRepositoryInterface
{


    public function all()
    {
        return Gallery::all();
    }

    public function findById($galleryId)
    {
        return Gallery::findOrFail($galleryId);
    }

    public function create(array $data)
    {
        return Gallery::create($data);
    }

    public function update(array $data, $galleryId)
    {
        $gallery = Gallery::findOrFail($galleryId);
        $gallery->update($data);
        return $gallery;
    }

    public function delete($galleryId)
    {
        $gallery = Gallery::findOrFail($galleryId);
        $gallery->delete();
    }
    public function findByBrokerId($brokerId)
    {
        return Gallery::where('broker_id', $brokerId)->first();
    }

    public function updateCover(array $data)
    {
    }
}
