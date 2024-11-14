<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\PropertyRepositoryInterface;
use App\Models\Broker;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Unit;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitRentalPrice;
use App\Models\UnitService;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function getAll($brokerId)
    {
        return Property::where('broker_id', $brokerId)->get();
    }

    public function store($data, $images)
    {
        $property_data = $data;
        unset($property_data['features_name']);
        unset($property_data['qty']);

          // Handle project_masterplan upload
          if (isset($property_data['property_masterplan'])) {
            $propertyMasterplan = $property_data['property_masterplan'];
            $ext = $propertyMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $propertyMasterplan->move(public_path('/Brokers/Properties/pdfs'), $masterplanName);
            $property_data['property_masterplan'] = '/Brokers/Properties/pdfs/' . $masterplanName;
        }

        // Handle project_brochure upload
        if (isset($property_data['property_brochure'])) {
            $propertyBrochure = $property_data['property_brochure'];
            $ext = $propertyBrochure->getClientOriginalExtension();
            $brochureName = uniqid() . '.' . $ext;
            $propertyBrochure->move(public_path('/Brokers/Properties/pdfs'), $brochureName);
            $property_data['property_brochure'] = '/Brokers/Properties/pdfs/' . $brochureName;
        }


        $property_data['broker_id'] = Auth::user()->UserBrokerData->id;

        if (isset($data['show_in_gallery'])) {
            $property_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

            $rules = [
                'ad_license_number' => ['required', 'numeric', Rule::unique('properties')],
                'ad_license_expiry' => 'required|date|after_or_equal:today',
            ];

            $messages = [
                'ad_license_number.required' => 'The license number is required.',
                'ad_license_number.unique' => __('The license number has already been taken.'),
                'ad_license_number.numeric' => 'The license number must be a number.',
                'ad_license_expiry.required' => 'The license expiry date is required.',
                'ad_license_expiry.date' => 'The license expiry date is not a valid date.',
                'ad_license_expiry.after_or_equal' => 'The license expiry date must be less than license date or equal.',
            ];

            validator($data, $rules ,$messages)->validate();

                $property_data['ad_license_number'] = $data['ad_license_number'];
                $property_data['ad_license_expiry'] = $data['ad_license_expiry'];
                $property_data['ad_license_status'] = 'Valid';

        } else {
            $property_data['show_in_gallery'] = 0;
            $property_data['ad_license_status'] ='InValid';

        }
        $property =  Property::create($property_data);

        if (isset($data['features_name'])) {
            foreach ($data['features_name'] as $index => $Feature_name) {
                $Feature =    Feature::where('name', $Feature_name)->first();
                if (!$Feature) {
                    $Feature =   Feature::create(['name' => $Feature_name, 'created_by' => Auth::id()]);
                }
                UnitFeature::create(['feature_id' => $Feature->id, 'property_id' => $property->id, 'qty' => $data['qty'][$index]]);
            }
        }
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
        $property_data = $data;
        unset($property_data['features_name']);
        unset($property_data['qty']);


        // Handle project_masterplan upload
        if (isset($property_data['property_masterplan'])) {
            if (!empty($property->property_masterplan) && File::exists(public_path($property->property_masterplan))) {
                File::delete(public_path($property->property_masterplan));
            }
          $propertyMasterplan = $property_data['property_masterplan'];
          $ext = $propertyMasterplan->getClientOriginalExtension();
          $masterplanName = uniqid() . '.' . $ext;
          $propertyMasterplan->move(public_path('/Brokers/Properties/pdfs'), $masterplanName);
          $property_data['property_masterplan'] = '/Brokers/Properties/pdfs/' . $masterplanName;
      }

      // Handle project_brochure upload
      if (isset($property_data['property_brochure'])) {
        if (!empty($property->property_brochure) && File::exists(public_path($property->property_brochure))) {
            File::delete(public_path($property->property_brochure));
        }
          $propertyBrochure = $property_data['property_brochure'];
          $ext = $propertyBrochure->getClientOriginalExtension();
          $brochureName = uniqid() . '.' . $ext;
          $propertyBrochure->move(public_path('/Brokers/Properties/pdfs'), $brochureName);
          $property_data['property_brochure'] = '/Brokers/Properties/pdfs/' . $brochureName;
      }

      if (isset($data['show_in_gallery'])) {
        $property_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

        $rules = [
            'ad_license_number' => [
                'required',
                'numeric',
                Rule::unique('properties', 'ad_license_number')->ignore($id),
            ],
            'ad_license_expiry' => 'required|date|after_or_equal:today',
        ];

        $messages = [
            'ad_license_number.required' => 'The license number is required.',
            'ad_license_number.unique' => __('The license number has already been taken.'),
            'ad_license_number.numeric' => 'The license number must be a number.',
            'ad_license_expiry.required' => 'The license expiry date is required.',
            'ad_license_expiry.date' => 'The license expiry date is not a valid date.',
            'ad_license_expiry.after_or_equal' => 'The license expiry date must be less than license date or equal.',
        ];

        validator($data, $rules ,$messages)->validate();

            $property_data['ad_license_number'] = $data['ad_license_number'];
            $property_data['ad_license_expiry'] = $data['ad_license_expiry'];
            $property_data['ad_license_status'] = 'Valid';

    } else {
        $property_data['show_in_gallery'] = 0;
        // $property_data['ad_license_number'] = null;
        // $property_data['ad_license_expiry'] = null;
        // $property_data['ad_license_status'] ='InValid';

    }

    if (isset($data['features_name'])) {
        $property->UnitFeatureData()->delete();
        foreach ($data['features_name'] as $index => $Feature_name) {
            $Feature =    Feature::where('name', $Feature_name)->first();
            if (!$Feature) {
                $Feature =   Feature::create(['name' => $Feature_name, 'created_by' => Auth::id()]);
            }
            UnitFeature::create(['feature_id' => $Feature->id, 'property_id' => $property->id, 'qty' => $data['qty'][$index]]);
        }
    }

        if ($images) {
            foreach ($images as $image) {
                $property->PropertyImages()->delete();
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Brokers/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Brokers/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        };
        $property->update($property_data);
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
        unset($unit_data['monthly']);
        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        $unit_data['property_id'] = $id;
        // if (isset($data['show_in_gallery'])) {
        //     if ($data['show_in_gallery'] == 'on') {
        //         $unit_data['show_in_gallery'] = 1;
        //     } else {
        //         $unit_data['show_in_gallery'] = 0;
        //     }
        // } else {
        //     $unit_data['show_in_gallery'] = 0;
        // }

        if (isset($data['show_in_gallery'])) {
            $unit_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

            $rules = [
                'ad_license_number' => ['required', 'numeric', Rule::unique('units')],
                'ad_license_expiry' => 'required|date|after_or_equal:today',
            ];

            $messages = [
                'ad_license_number.required' => 'The license number is required.',
                'ad_license_number.unique' => __('The license number has already been taken.'),
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
            $unit_data['show_in_gallery'] = 0;
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

        UnitRentalPrice::create([
            'unit_id' => $unit->id,
            'daily' => $data['monthly'] / 30,
            'monthly' => $data['monthly'],
            'quarterly' => $data['monthly'] * 3,
            'midterm' => $data['monthly'] * 6,
            'yearly' => $data['monthly'] * 12,
        ]);

        if (isset($data['service_id'])) {
            foreach ($data['service_id'] as  $service) {
                UnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
            }
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
                    $image->move(public_path() . '/Brokers/Projects/Unit/Images/', $ext);
                    UnitImage::create([
                        'image' => '/Brokers/Projects/Unit/Images/' . $ext,
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


        return redirect()->route('Broker.Property.index')->with('success', __('added successfully'));
    }

    function ShowPublicProperty($id)
    {
        $property = Property::where('show_in_gallery', 1)->find($id);
        if($property){
            $broker = Broker::findOrFail($property->broker_id);
            $gallery =Gallery::where('broker_id', $broker->id)->first();

            $visitor = Visitor::where('property_id', $id)
            ->where('ip_address', request()->ip())
            ->where('visited_at', '>=', now()->subHour())
            ->first();

        if (!$visitor) {

            $newVisitor = new Visitor();
            $newVisitor->property_id = $id;
            $newVisitor->gallery_id = $gallery->id;
            $newVisitor->ip_address = request()->ip();
            $newVisitor->visited_at = now();
            $newVisitor->save();
        }
        $unitVisitorsCount = Visitor::where('property_id', $property->id)->distinct('ip_address')->count('ip_address');

            return $property;
        }


    }
}
