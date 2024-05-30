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
use App\Models\UnitRentalPrice;
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
        $rules = [
            'monthly' => 'digits_between:0,8',
            'daily' => 'digits_between:0,8',
            'quarterly' => 'digits_between:0,8',
            'midterm' => 'digits_between:0,10',
            'yearly' => 'digits_between:0,10',



        ];

        // Define custom validation messages
        $messages = [

            'monthly' => 'Monthly price must be smaller than or equal to 8.',
            'daily' => 'Monthly price must be smaller than or equal to 8.',
            'quarterly' => 'Monthly price must be smaller than or equal to 8.',
            'midterm' => 'Monthly price must be smaller than or equal to 10.',
            'yearly' => 'Monthly price must be smaller than or equal to 10.',

        ];

        $unit_data = $data;
        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        unset($unit_data['service_id']);
        unset($unit_data['monthly']);
        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        if (isset($data['show_gallery'])) {
            $unit_data['show_gallery'] = $data['show_gallery'] == 'on' ? 1 : 0;
        } else {
            $unit_data['show_gallery'] = 0;
        }

        if (isset($data['daily_rent'])) {
            $unit_data['daily_rent'] = $data['daily_rent'] == 'on' ? 1 : 0;
        } else {
            $unit_data['daily_rent'] = 0;
        }

        if (isset($unit_data['unit_masterplan'])) {
            $unitMasterplan = $unit_data['unit_masterplan'];
            $ext = $unitMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $unitMasterplan->move(public_path('/Brokers/Projects/Units/'), $masterplanName);
            $unit_data['unit_masterplan'] = '/Brokers/Projects/Units/' . $masterplanName;
        }


        $unit = Unit::create($unit_data);
        if (isset($data['service_id'])) {
            foreach ($data['service_id'] as  $service) {
                UnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
            }
        }
        UnitRentalPrice::create([
            'unit_id' => $unit->id,
            'daily' => $data['monthly'] / 30,
            'monthly' => $data['monthly'],
            'quarterly' => $data['monthly'] * 3,
            'midterm' => $data['monthly'] * 6,
            'yearly' => $data['monthly'] * 12,
        ]);
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
        $rules = [
            'monthly' => 'digits_between:0,8',
            'daily' => 'digits_between:0,8',
            'quarterly' => 'digits_between:0,8',
            'midterm' => 'digits_between:0,10',
            'yearly' => 'digits_between:0,10',



        ];

        // Define custom validation messages
        $messages = [

            'monthly' => 'Monthly price must be smaller than or equal to 8.',
            'daily' => 'daily price must be smaller than or equal to 8.',
            'quarterly' => 'quarterly price must be smaller than or equal to 8.',
            'midterm' => 'midterm price must be smaller than or equal to 10.',
            'yearly' => 'yearly price must be smaller than or equal to 10.',

        ];

        $unit_data = $data;
        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        unset($unit_data['service_id']);
        unset($unit_data['daily']);
        unset($unit_data['monthly']);
        unset($unit_data['quarterly']);
        unset($unit_data['midterm']);
        unset($unit_data['yearly']);


        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        if (isset($data['show_gallery'])) {
            $unit_data['show_gallery'] = $data['show_gallery'] == 'on' ? 1 : 0;
        } else {
            $unit_data['show_gallery'] = 0;
        }

        if (isset($data['daily_rent'])) {
            $unit_data['daily_rent'] = $data['daily_rent'] == 'on' ? 1 : 0;
        } else {
            $unit_data['daily_rent'] = 0;
        }

        $unit = Unit::find($id);
        $unit->update($unit_data);
        if (isset($data['service_id'])) {
            $unit->UnitServicesData()->delete();
            foreach ($data['service_id'] as  $service) {
                UnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
            }
        }
        UnitRentalPrice::updateOrCreate(['unit_id' => $unit->id], [
            'unit_id' => $unit->id,
            'daily' => $data['daily'],
            'monthly' => $data['monthly'],
            'quarterly' => $data['quarterly'],
            'midterm' => $data['midterm'],
            'yearly' => $data['yearly'],
        ]);

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
