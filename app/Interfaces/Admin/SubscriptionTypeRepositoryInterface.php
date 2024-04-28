<?php

namespace App\Interfaces\Admin;

use App\Models\SubscriptionType;

interface SubscriptionTypeRepositoryInterface
{
    public function getAll();
    public function getSubscriptionTypeAll();

    public function getAllFiltered($status, $period, $price);


    public function create($data);

    public function findById($id);

    public function update($id, $data);

    public function delete($id);
    public function getUserSubscriptionTypes();
    public function getGallerySubscriptionTypes();




}
