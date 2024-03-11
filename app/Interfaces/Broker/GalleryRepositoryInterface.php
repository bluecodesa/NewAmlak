<?php
namespace App\Interfaces\Broker;

interface GalleryRepositoryInterface
{
    public function all();

    public function findById($galleryId);

    public function create(array $data);

    public function update(array $data, $galleryId);

    public function delete($galleryId);

    public function updateCover(array $data);
    public function findByBrokerId($brokerId);


}
