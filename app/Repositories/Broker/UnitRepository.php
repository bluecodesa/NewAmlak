<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Unit;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitService;
use Illuminate\Support\Facades\Auth;


class UnitRepository implements UnitRepositoryInterface
{
    public function getAll($brokerId)
    {
        return Unit::where('broker_id', $brokerId)->get();
    }

    public function store($data)
    {
        $unit_data = $data;
        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        unset($unit_data['service_id']);
        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        if ($data['show_gallery'] == 'on') {
            $unit_data['show_gallery'] = 1;
        } else {
            $unit_data['show_gallery'] = 0;
        }
        $unit = Unit::create($unit_data);
        foreach ($data['service_id'] as  $service) {
            UnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
        }
        if (isset($data['name'])) {
            foreach ($data['name'] as $index => $Feature_name) {
                $Feature =    Feature::where('name', $Feature_name)->first();
                if (!$Feature) {
                    $Feature =   Feature::create(['name' => $Feature_name, 'created_by' => Auth::id()]);
                }
                UnitFeature::create(['feature_id' => $Feature->id, 'unit_id' => $unit->id, 'qty' => $data['qty'][$index]]);
            }
        }
        if (isset($data['images'])) {
            $images = $data['images'];
            if ($images) {
                foreach ($images as $image) {
                    $ext = uniqid() . '.' . $image->clientExtension();
                    $image->move(public_path() .  '/Brokers/Projects/Property/Unit/' . $unit->number_unit . '/', $ext);
                    UnitImage::create([
                        'image' =>  '/Brokers/Projects/Property/Unit/' . $unit->number_unit . '/' . $ext,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }
    }

    public function update($id, $data)
    {
        $unit_data = $data;
        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        unset($unit_data['service_id']);
        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        if (isset($data['service_id'])) {
            if ($data['show_gallery'] == 'on') {
                $unit_data['show_gallery'] = 1;
            } else {
                $unit_data['show_gallery'] = 0;
            }
        } else {
            $unit_data['show_gallery'] = 1;
        }
        $unit = Unit::find($id);
        $unit->update($unit_data);
        if (isset($data['service_id'])) {
            $unit->UnitServicesData()->delete();
            foreach ($data['service_id'] as  $service) {
                UnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
            }
        }
        if (isset($data['name'])) {
            $unit->UnitFeatureData()->delete();
            foreach ($data['name'] as $index => $Feature_name) {
                $Feature =    Feature::where('name', $Feature_name)->first();
                if (!$Feature) {
                    $Feature =   Feature::create(['name' => $Feature_name, 'created_by' => Auth::id()]);
                }
                UnitFeature::create(['feature_id' => $Feature->id, 'unit_id' => $unit->id, 'qty' => $data['qty'][$index]]);
            }
        }
        if (isset($data['images'])) {
            $unit->UnitImages()->delete();
            $images = $data['images'];
            if ($images) {
                foreach ($images as $image) {
                    $ext = uniqid() . '.' . $image->clientExtension();
                    $image->move(public_path() .  '/Brokers/Projects/Property/Unit/' . $unit->number_unit . '/', $ext);
                    UnitImage::create([
                        'image' =>  '/Brokers/Projects/Property/Unit/' . $unit->number_unit . '/' . $ext,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }
    }



    function findById($id)
    {
        return Unit::find($id);
    }

    public function delete($id)
    {
        return Unit::destroy($id);
    }
}
