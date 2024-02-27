<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\PropertyRepositoryInterface;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function getAll($brokerId)
    {
        return Property::where('broker_id', $brokerId)->get();
    }

    public function store($data, $images)
    {
        $property =  Property::create($data);
        if ($images) {
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Brokers/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Brokers/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        }
        return $property;
    }

    public function update($id, $data, $images)
    {
        $property = Property::findOrFail($id);
        if ($images) {
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Brokers/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Brokers/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        };
        return $property;
    }



    function findById($id)
    {
        return Property::find($id);
    }

    public function delete($id)
    {
        return Property::destroy($id);
    }
}
