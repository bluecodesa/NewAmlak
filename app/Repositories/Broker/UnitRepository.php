<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Unit;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitRentalPrice;
use App\Models\UnitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;



class UnitRepository implements UnitRepositoryInterface
{
    public function getAll($brokerId)
    {
        return Unit::where('broker_id', $brokerId)->get();
    }

    public function getAllByOffice($officeId)
    {
        return Unit::where('office_id', $officeId)->get();
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
        // unset($unit_data['videos']);
        unset($unit_data['service_id']);
        unset($unit_data['monthly']);
        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        // if (isset($data['show_gallery'])) {
        //     $unit_data['show_gallery'] = $data['show_gallery'] == 'on' ? 1 : 0;
        // } else {
        //     $unit_data['show_gallery'] = 0;
        // }

        if (isset($data['show_gallery'])) {
            $unit_data['show_gallery'] = $data['show_gallery'] == 'on' ? 1 : 0;

            $rules = [
                'ad_license_number' => 'required|numeric',
                'ad_license_expiry' => 'required|date|after_or_equal:today',
            ];

            $messages = [
                'ad_license_number.required' => 'The license number is required.',
                'ad_license_number.numeric' => 'The license number must be a number.',
                'ad_license_expiry.required' => 'The license expiry date is required.',
                'ad_license_expiry.date' => 'The license expiry date is not a valid date.',
                'ad_license_expiry.after_or_equal' => 'The license expiry date must be less than license date or equal.',
            ];

            validator($data, $rules ,$messages)->validate();

                $unit_data['ad_license_number'] = $data['ad_license_number'];
                $unit_data['ad_license_expiry'] = $data['ad_license_expiry'];
                $unit_data['ad_license_status'] = 'Valid';

        } else {
            $unit_data['show_gallery'] = 0;
            $unit_data['ad_license_status'] ='InValid';

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

        if (isset($unit_data['video'])) {
            $video = $unit_data['video'];
            $ext = $video->getClientOriginalExtension();
            $videoName = uniqid() . '.' . $ext;
            $video->move(public_path('/Brokers/Projects/Unit/Video/'), $videoName);
            $unit_data['video'] = '/Brokers/Projects/Unit/Video/' . $videoName;
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
                    $ext = $image->getClientOriginalExtension();
                    $filename = uniqid() . '.' . $ext;
                    $image->move(public_path() . '/Brokers/Projects/Unit/Images/' . $unit->number_unit . '/', $filename);
                    UnitImage::create([
                        'image' => '/Brokers/Projects/Unit/Images/' . $unit->number_unit . '/' . $filename,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }


        // if (isset($unit_data['videos'])) {
        //     $videos = $data['videos'];
        //     if ($videos) {
        //         foreach ($videos as $video) {
        //             $ext = $video->getClientOriginalExtension();
        //             $filename = uniqid() . '.' . $ext;
        //             $video->move(public_path() . '/Brokers/Projects/Unit/Videos/' . $unit->number_unit . '/', $filename);
        //             UnitImage::create([
        //                 'image' => '/Brokers/Projects/Unit/Videos/' . $unit->number_unit . '/' . $filename,
        //                 'unit_id' => $unit->id,
        //             ]);
        //         }
        //     }
        // }

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

            $rules = [
                'ad_license_number' => 'required|numeric',
                'ad_license_expiry' => 'required|date|after_or_equal:today',
            ];

            $messages = [
                'ad_license_number.required' => 'The license number is required.',
                'ad_license_number.numeric' => 'The license number must be a number.',
                'ad_license_expiry.required' => 'The license expiry date is required.',
                'ad_license_expiry.date' => 'The license expiry date is not a valid date.',
                'ad_license_expiry.after_or_equal' => 'The license expiry date must be less than license date or equal.',
            ];

            validator($data, $rules ,$messages)->validate();

                $unit_data['ad_license_number'] = $data['ad_license_number'];
                $unit_data['ad_license_expiry'] = $data['ad_license_expiry'];
                $unit_data['ad_license_status'] = 'Valid';

        } else {
            $unit_data['show_gallery'] = 0;
            $unit_data['ad_license_status'] ='InValid';

        }

        if (isset($data['daily_rent'])) {
            $unit_data['daily_rent'] = $data['daily_rent'] == 'on' ? 1 : 0;
        } else {
            $unit_data['daily_rent'] = 0;
        }

        $unit = Unit::find($id);

        if (isset($unit_data['unit_masterplan'])) {
            if (!empty($unit->project_brochure) && File::exists(public_path($unit->project_brochure))) {
                File::delete(public_path($unit->project_brochure));
            }
            $unitMasterplan = $unit_data['unit_masterplan'];
            $ext = $unitMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $unitMasterplan->move(public_path('/Brokers/Projects/Units/'), $masterplanName);
            $unit_data['unit_masterplan'] = '/Brokers/Projects/Units/' . $masterplanName;
        }

        if (isset($unit_data['video'])) {
            if (!empty($unit->video) && File::exists(public_path($unit->video))) {
                File::delete(public_path($unit->video));
            }
            $video = $unit_data['video'];
            $ext = $video->getClientOriginalExtension();
            $videoName = uniqid() . '.' . $ext;
            $video->move(public_path('/Brokers/Projects/Unit/Video/'), $videoName);
            $unit_data['video'] = '/Brokers/Projects/Unit/Video/' . $videoName;
        }

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
                    $image->move(public_path() .  '/Brokers/Projects/Unit/Images' . $unit->number_unit . '/', $ext);
                    UnitImage::create([
                        'image' =>  '/Brokers/Projects/Unit/Images' . $unit->number_unit . '/' . $ext,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }
        // if (isset($data['videos'])) {
        //     $videos = $data['videos'];
        //     if ($videos) {
        //         foreach ($videos as $video) {
        //             $ext = $video->getClientOriginalExtension();
        //             $filename = uniqid() . '.' . $ext;
        //             $video->move(public_path() . '/Brokers/Projects/Unit/Videos/' . $unit->number_unit . '/', $filename);
        //             UnitImage::create([
        //                 'image' => '/Brokers/Projects/Unit/Videos/' . $unit->number_unit . '/' . $filename,
        //                 'unit_id' => $unit->id,
        //             ]);
        //         }
        //     }
        // }
    }



    function findById($id)
    {
        return Unit::find($id);
    }

    public function delete($id)
    {
        return Unit::destroy($id);
    }

    public function getAllUnitsForGalleriesWithShowGallery()
    {
        $units = collect();

        $galleries = Gallery::where('gallery_status', 1)->get();

        foreach ($galleries as $gallery) {
            $galleryUnits = Unit::where('broker_id', $gallery->broker_id)
                ->where('show_gallery', 1)
                ->get();

            $units = $units->merge($galleryUnits);
        }
        return $units;
    }
}
