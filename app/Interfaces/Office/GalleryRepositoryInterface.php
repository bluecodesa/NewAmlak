<?php
namespace App\Interfaces\Office;

interface GalleryRepositoryInterface
{
    public function all();
    public function allPublic();


    public function findById($galleryId);

    public function create(array $data);

    public function update(array $data, $galleryId);

    public function delete($galleryId);

    public function updateCover(array $data);
    public function findByOfficeId($officeId);
    public function findByGalleryName($galleryName);
    public function findRecentVisitor(int $galleryId, string $ipAddress);



}
