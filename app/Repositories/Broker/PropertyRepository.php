<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\PropertyRepositoryInterface;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Unit;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

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

    public function autocomplete($data)
    {
        return Feature::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $data['search'] . '%')
            ->get();
    }


    function StoreUnit($id, $data)
    {
        $unit_data = $data;
        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        unset($unit_data['service_id']);
        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        $unit_data['property_id'] = $id;

        if ($data['show_gallery'] == 'on') {
            $unit_data['show_gallery'] = 1;
        } else {
            $unit_data['show_gallery'] = 0;
        }
        $unit = Unit::create($unit_data);
        foreach ($data['service_id'] as  $service) {
            UnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
        }
        foreach ($data['name'] as $index => $Feature_name) {
            $Feature =    Feature::where('name', $Feature_name)->first();
            if (!$Feature) {
                $Feature =   Feature::create(['name' => $Feature_name, 'created_by' => Auth::id()]);
            }
            UnitFeature::create(['feature_id' => $Feature->id, 'unit_id' => $unit->id, 'qty' => $data['qty'][$index]]);
        }
        if (isset($data['images'])) {
            $images = $data['images'];
            if ($images) {
                foreach ($images as $image) {
                    $ext = uniqid() . '.' . $image->clientExtension();
                    $image->move(public_path() . '/Brokers/Projects/Property/Unit', $ext);
                    UnitImage::create([
                        'image' => '/Brokers/Projects/Property/Unit' . $ext,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }


        return redirect()->route('Broker.Property.index')->with('success', __('added successfully'));
    }
}
