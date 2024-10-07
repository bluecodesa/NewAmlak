<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\ProjectRepositoryInterface;
use App\Models\Feature;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectStatus;
use App\Models\ProjectTimeLine;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\TicketType;
use App\Models\Unit;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitRentalPrice;
use App\Models\UnitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;



class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllByBrokerId($brokerId)
    {
        return Project::where('broker_id', $brokerId)->get();
    }

    public function create($data, $files)
    {
        $project_data = $data;


        // Handle project_masterplan upload
        if (isset($files['project_masterplan'])) {
            $projectMasterplan = $files['project_masterplan'];
            $ext = $projectMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $projectMasterplan->move(public_path('/Brokers/Projects/pdfs'), $masterplanName);
            $project_data['project_masterplan'] = '/Brokers/Projects/pdfs/' . $masterplanName;
        }

        // Handle project_brochure upload
        if (isset($files['project_brochure'])) {
            $projectBrochure = $files['project_brochure'];
            $ext = $projectBrochure->getClientOriginalExtension();
            $brochureName = uniqid() . '.' . $ext;
            $projectBrochure->move(public_path('/Brokers/Projects/pdfs'), $brochureName);
            $project_data['project_brochure'] = '/Brokers/Projects/pdfs/' . $brochureName;
        }


        $project_data['broker_id'] = Auth::user()->UserBrokerData->id;

        $license_date = auth()->user()->UserBrokerData->license_date;

        if (isset($data['show_in_gallery'])) {
            $project_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

            $rules = [
                'ad_license_number' => ['required', 'numeric', Rule::unique('projects')],
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

                $project_data['ad_license_number'] = $data['ad_license_number'];
                $project_data['ad_license_expiry'] = $data['ad_license_expiry'];
                $project_data['ad_license_status'] = 'Valid';
                // $project_data['ad_license_status'] = (strtotime($data['ad_license_expiry']) <= strtotime($license_date)) ? 'Valid' : 'Expired';

        } else {
            $project_data['show_in_gallery'] = 0;
            $project_data['ad_license_status'] ='InValid';

        }
        unset($project_data['time_line']);
        unset($project_data['date']);
        unset($project_data['images']);


        $project = Project::create($project_data);

        if (isset($data['time_line'])) {
            foreach ($data['time_line'] as $index => $statusId) {
                if (!empty($statusId) && (isset($data['date'][$index]) || $data['date'][$index] === null)) {
                    ProjectTimeLine::create([
                        'status_id' => $statusId,
                        'project_id' => $project->id,
                        'date' => $data['date'][$index],
                    ]);
                }
            }
        }
        if (isset($files['images'])) {
            foreach ($files['images'] as $image) {
                $ext = $image->getClientOriginalExtension();
                $imageName = uniqid() . '.' . $ext;
                $image->move(public_path('/Brokers/Projects/'), $imageName);
                ProjectImage::create([
                    'image' => '/Brokers/Projects/' . $imageName,
                    'project_id' => $project->id,
                ]);
            }
        }

        return $project;
    }

    public function update($id, $data, $images)
    {

        $project_data = $data;
        $project = Project::findOrFail($id);

        if (isset($data['show_in_gallery'])) {
            $project_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;

            $rules = [
                'ad_license_number' => [
                    'required',
                    'numeric',
                    Rule::unique('projects', 'ad_license_number')->ignore($id),
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

                $project_data['ad_license_number'] = $data['ad_license_number'];
                $project_data['ad_license_expiry'] = $data['ad_license_expiry'];
                $project_data['ad_license_status'] = 'Valid';
                // $project_data['ad_license_status'] = (strtotime($data['ad_license_expiry']) <= strtotime($license_date)) ? 'Valid' : 'Expired';

        } else {
            $project_data['show_in_gallery'] = 0;
            // $project_data['ad_license_status'] ='InValid';

        }

          // Handle project_masterplan upload
          if (isset($project_data['project_masterplan'])) {
            if (!empty($project->project_masterplan) && File::exists(public_path($project->project_masterplan))) {
                File::delete(public_path($project->project_masterplan));
            }
            $projectMasterplan = $project_data['project_masterplan'];
            $ext = $projectMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $projectMasterplan->move(public_path('/Brokers/Projects/pdfs'), $masterplanName);
            $project_data['project_masterplan'] = '/Brokers/Projects/pdfs/' . $masterplanName;
        }

        // Handle project_brochure upload
        if (isset($project_data['project_brochure'])) {
            if (!empty($project->project_brochure) && File::exists(public_path($project->project_brochure))) {
                File::delete(public_path($project->project_brochure));
            }
            $projectBrochure = $project_data['project_brochure'];
            $ext = $projectBrochure->getClientOriginalExtension();
            $brochureName = uniqid() . '.' . $ext;
            $projectBrochure->move(public_path('/Brokers/Projects/pdfs'), $brochureName);
            $project_data['project_brochure'] = '/Brokers/Projects/pdfs/' . $brochureName;
        }

        // if ($images) {
        //     $ext = $images->getClientOriginalExtension();
        //     $imageName = uniqid() . '.' . $ext;
        //     $images->move(public_path('/Brokers/Projects/'), $imageName);
        //     $data['image'] = '/Brokers/Projects/' . $imageName;
        //     // } else {
        //     // $data['image'] = '/Brokers/Projects/default.svg';
        // }
        unset($project_data['time_line']);
        unset($project_data['date']);

        if ($images) {
            $project->ProjectImages()->delete();
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Brokers/Projects/', $ext);
                ProjectImage::create([
                    'image' => '/Brokers/Projects/' . $ext,
                    'project_id' => $project->id,
                ]);
            }
        };
        $project->update($project_data);
        if (isset($data['time_line'])) {
            $project->ProjectTimeLineData()->delete();
            foreach ($data['time_line'] as $index => $statusId) {
                if (!empty($statusId) && (isset($data['date'][$index]) || $data['date'][$index] === null)) {
                    ProjectTimeLine::create([
                        'status_id' => $statusId,
                        'project_id' => $project->id,
                        'date' => $data['date'][$index],
                    ]);
                }
            }
        }
        return $project;
    }



    function ShowProject($id)
    {
        return Project::find($id);
    }

    function ShowPublicProject($id)
    {
        $project = Project::where('show_in_gallery', 1)->find($id);
        return $project;

    }
    public function delete($id)
    {
        return Project::destroy($id);
    }

    public function storeProperty($data, $id, $images)
    {
        $property_data = $data;

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

    //   if (isset($data['show_in_gallery'])) {
    //       $property_data['show_in_gallery'] = $data['show_in_gallery'] == 'on' ? 1 : 0;
    //   } else {
    //       $property_data['show_in_gallery'] = 0;
    //   }
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

    function StoreUnit($id, $data)
    {
        $unit_data = $data;
        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        unset($unit_data['service_id']);
        unset($unit_data['monthly']);
        $unit_data['broker_id'] = Auth::user()->UserBrokerData->id;
        $unit_data['project_id'] = $id;
        // if (isset($data['show_gallery'])) {
        //     if ($data['show_gallery'] == 'on') {
        //         $unit_data['show_gallery'] = 1;
        //     } else {
        //         $unit_data['show_gallery'] = 0;
        //     }
        // } else {
        //     $unit_data['show_gallery'] = 0;
        // }
        if (isset($data['show_gallery'])) {
            $unit_data['show_gallery'] = $data['show_gallery'] == 'on' ? 1 : 0;

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

        return redirect()->route('Broker.Project.index')->with('success', __('added successfully'));
    }

    public function autocomplete($data)
    {
        return Feature::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $data['search'] . '%')
            ->get();
    }

}
