<?php

namespace App\Repositories\Home;

use App\Interfaces\Home\GalleryRepositoryInterface;
use App\Models\Gallery;

class GalleryRepository implements GalleryRepositoryInterface
{


    public function all()
    {
        return Gallery::all();
    }
    public function allPublic()
    {
        return Gallery::where('gallery_status',1)->get();
    }


    public function findById($galleryId)
    {
        return Gallery::findOrFail($galleryId);
    }


    public function findByBrokerId($brokerId)
    {
        return Gallery::where('broker_id', $brokerId)->first();
    }

    public function findByOfficeId($officeId)
    {
        return Gallery::where('office_id', $officeId)->first();
    }


    public function findByGalleryName($galleryName)
    {
        return Gallery::where('gallery_name', $galleryName)->firstOrFail();
    }
}
