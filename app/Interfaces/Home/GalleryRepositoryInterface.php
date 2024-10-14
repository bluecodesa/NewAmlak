<?php
namespace App\Interfaces\Home;

interface GalleryRepositoryInterface
{
    public function all();
    public function allPublic();


    public function findById($galleryId);

    public function findByBrokerId($brokerId);
    public function findByOfficeId($officeId);
    public function findByGalleryName($galleryName);
    public function ShowPublicProperty($id);
    public function ShowPublicProject($id);




}
