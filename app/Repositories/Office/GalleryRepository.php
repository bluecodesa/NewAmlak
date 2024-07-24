<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\GalleryRepositoryInterface;
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

    public function create(array $data)
    {
        return Gallery::create($data);
    }

    public function update(array $data, $galleryId)
    {
        $gallery = Gallery::findOrFail($galleryId);

        $gallery->update([
            'gallery_name' => $data['gallery_name'],
            'gallery_status' => isset($data['gallery_status']) ? '1' : '0',
        ]);
              return $gallery;
    }

    public function delete($galleryId)
    {
        $gallery = Gallery::findOrFail($galleryId);
        $gallery->delete();
    }
    public function findByOfficeId($officeId)
    {
        return Gallery::where('office_id', $officeId)->first();
    }

    public function updateCover(array $data)
    {
        $gallery = $this->findById($data['gallery_id']);

        if (isset($data['gallery_cover'])) {
            $file = $data['gallery_cover'];
            $ext = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Gallery/cover/'), $ext);
            $gallery->update(['gallery_cover' => 'Gallery/cover/' . $ext]);
        }

        return $gallery;
    }

    public function findByGalleryName($galleryName)
    {
        return Gallery::where('gallery_name', $galleryName)->firstOrFail();
    }
}
