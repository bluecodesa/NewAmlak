<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Office;

use App\Http\Traits\Email\MailUnitPublished;
use App\Http\Traits\WhatsApp\WhatsappUnitPublished;
use App\Interfaces\Office\PropertyRepositoryInterface;
use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Unit;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitRentalPrice;
use App\Models\UnitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class PropertyRepository implements PropertyRepositoryInterface
{
    use MailUnitPublished;
    use WhatsappUnitPublished;
    public function getAll($officeId)
    {
        return Property::where('office_id', $officeId)->get();
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
            $propertyMasterplan->move(public_path('/Offices/Properties/pdfs'), $masterplanName);
            $property_data['property_masterplan'] = '/Offices/Properties/pdfs/' . $masterplanName;
        }

        // Handle project_brochure upload
        if (isset($property_data['property_brochure'])) {
            $propertyBrochure = $property_data['property_brochure'];
            $ext = $propertyBrochure->getClientOriginalExtension();
            $brochureName = uniqid() . '.' . $ext;
            $propertyBrochure->move(public_path('/Offices/Properties/pdfs'), $brochureName);
            $property_data['property_brochure'] = '/Offices/Properties/pdfs/' . $brochureName;
        }


        $property_data['office_id'] = Auth::user()->UserOfficeData->id;

        if (isset($data['show_in_gallery'])) {
            $property_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

            $rules = [
            'ad_license_number' => [
            'required',
            'numeric',
                function ($attribute, $value, $fail) {
                    // Check in `properties` table
                    if (DB::table('properties')->where('ad_license_number', $value)->exists()) {
                        return $fail("The $attribute has already been taken in the properties table.");
                    }
                    // Check in `units` table
                    if (DB::table('units')->where('ad_license_number', $value)->exists()) {
                        return $fail("The $attribute has already been taken in the units table.");
                    }
                    // Check in `projects` table
                    if (DB::table('projects')->where('ad_license_number', $value)->exists()) {
                        return $fail("The $attribute has already been taken in the projects table.");
                    }
                },
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
                $image->move(public_path() . '/Offices/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Offices/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        }

        if ($property->show_in_gallery == 1) {
            $this->MailUnitPublished($property);
            $this->WhatsappUnitPublished($property);
        }

        return $property;
    }

    public function update($id, $data, $images)
    {
        $old_property = Property::findOrFail($id);
// dd($data);
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
          $propertyMasterplan->move(public_path('/Offices/Properties/pdfs'), $masterplanName);
          $property_data['property_masterplan'] = '/Offices/Properties/pdfs/' . $masterplanName;
      }

      // Handle project_brochure upload
      if (isset($property_data['property_brochure'])) {
        if (!empty($property->property_brochure) && File::exists(public_path($property->property_brochure))) {
            File::delete(public_path($property->property_brochure));
        }
          $propertyBrochure = $property_data['property_brochure'];
          $ext = $propertyBrochure->getClientOriginalExtension();
          $brochureName = uniqid() . '.' . $ext;
          $propertyBrochure->move(public_path('/Offices/Properties/pdfs'), $brochureName);
          $property_data['property_brochure'] = '/Offices/Properties/pdfs/' . $brochureName;
      }

      if (isset($data['show_in_gallery'])) {
        $property_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

        $rules = [
            'ad_license_number' => [
                'required',
                'numeric',
            function ($attribute, $value, $fail) use ($id) {
                // Check in `properties` table, ignore current property ID
                if (DB::table('properties')->where('ad_license_number', $value)->where('id', '<>', $id)->exists()) {
                    return $fail("The $attribute has already been taken in the properties table.");
                }
                // Check in `units` table, ignore current property ID
                if (DB::table('units')->where('ad_license_number', $value)->where('id', '<>', $id)->exists()) {
                    return $fail("The $attribute has already been taken in the units table.");
                }
                // Check in `projects` table, ignore current property ID
                if (DB::table('projects')->where('ad_license_number', $value)->where('id', '<>', $id)->exists()) {
                    return $fail("The $attribute has already been taken in the projects table.");
                }
            },
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
                $image->move(public_path() . '/Offices/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Offices/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        };
        $property->update($property_data);
        if ($old_property->show_in_gallery == 0 && $property->show_in_gallery == 1) {
            $this->MailUnitPublished($property);
            $this->WhatsappUnitPublished($property);
        }

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
        $unit_data['office_id'] = Auth::user()->UserOfficeData->id;
        $unit_data['property_id'] = $id;
        if (isset($data['show_in_gallery'])) {
            $unit_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

            $rules = [
                'ad_license_number' => [
                    'required',
                    'numeric',
                        function ($attribute, $value, $fail) {
                            // Check in `properties` table
                            if (DB::table('properties')->where('ad_license_number', $value)->exists()) {
                                return $fail("The $attribute has already been taken in the properties table.");
                            }
                            // Check in `units` table
                            if (DB::table('units')->where('ad_license_number', $value)->exists()) {
                                return $fail("The $attribute has already been taken in the units table.");
                            }
                            // Check in `projects` table
                            if (DB::table('projects')->where('ad_license_number', $value)->exists()) {
                                return $fail("The $attribute has already been taken in the projects table.");
                            }
                        },
                    ],                'ad_license_expiry' => 'required|date|after_or_equal:today',
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
            $unitMasterplan->move(public_path('/Offices/Projects/Units/'), $masterplanName);
            $unit_data['unit_masterplan'] = '/Offices/Projects/Units/' . $masterplanName;
        }
        if (isset($unit_data['video'])) {
            $video = $unit_data['video'];
            $ext = $video->getClientOriginalExtension();
            $videoName = uniqid() . '.' . $ext;
            $video->move(public_path('/Offices/Projects/Unit/Video/'), $videoName);
            $unit_data['video'] = '/Offices/Projects/Unit/Video/' . $videoName;
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
                    $image->move(public_path() . '/Offices/Projects/Property/Unit', $ext);
                    UnitImage::create([
                        'image' => '/Offices/Projects/Property/Unit/' . $ext,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }

        return redirect()->route('Office.Property.index')->with('success', __('added successfully'));
    }
}
