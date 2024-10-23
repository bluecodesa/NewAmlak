<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Office;

use App\Http\Traits\Email\MailUnitPublished;
use App\Http\Traits\WhatsApp\WhatsappUnitPublished;
use App\Interfaces\Office\ProjectRepositoryInterface;
use App\Models\Feature;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectTimeLine;
use App\Models\Property;
use App\Models\PropertyImage;
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

    use MailUnitPublished;
    use WhatsappUnitPublished;

    public function getAllByOfficeId($officeId)
    {
        return Project::where('office_id', $officeId)->get();
    }

    public function create($data, $files)
    {
        $project_data = $data;


        // Handle project_masterplan upload
        if (isset($files['project_masterplan'])) {
            $projectMasterplan = $files['project_masterplan'];
            $ext = $projectMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $projectMasterplan->move(public_path('/Offices/Projects/pdfs'), $masterplanName);
            $project_data['project_masterplan'] = '/Offices/Projects/pdfs/' . $masterplanName;
        }

        // Handle project_brochure upload
        if (isset($files['project_brochure'])) {
            $projectBrochure = $files['project_brochure'];
            $ext = $projectBrochure->getClientOriginalExtension();
            $brochureName = uniqid() . '.' . $ext;
            $projectBrochure->move(public_path('/Offices/Projects/pdfs'), $brochureName);
            $project_data['project_brochure'] = '/Offices/Projects/pdfs/' . $brochureName;
        }


        $project_data['office_id'] = Auth::user()->UserOfficeData->id;

        $license_date = auth()->user()->UserOfficeData->license_date;

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
                $image->move(public_path('/Offices/Projects/'), $imageName);
                ProjectImage::create([
                    'image' => '/Offices/Projects/' . $imageName,
                    'project_id' => $project->id,
                ]);
            }
        }

        if ($project->show_in_gallery == 1) {
            $this->MailUnitPublished($project);
            $this->WhatsappUnitPublished($project);
        }
        return $project;
    }

    public function update($id, $data, $images)
    {

        $project_data = $data;
        $old_project = Project::findOrFail($id);

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

        }

          // Handle project_masterplan upload
          if (isset($project_data['project_masterplan'])) {
            if (!empty($project->project_masterplan) && File::exists(public_path($project->project_masterplan))) {
                File::delete(public_path($project->project_masterplan));
            }
            $projectMasterplan = $project_data['project_masterplan'];
            $ext = $projectMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $projectMasterplan->move(public_path('/Offices/Projects/pdfs'), $masterplanName);
            $project_data['project_masterplan'] = '/Offices/Projects/pdfs/' . $masterplanName;
        }

        // Handle project_brochure upload
        if (isset($project_data['project_brochure'])) {
            if (!empty($project->project_brochure) && File::exists(public_path($project->project_brochure))) {
                File::delete(public_path($project->project_brochure));
            }
            $projectBrochure = $project_data['project_brochure'];
            $ext = $projectBrochure->getClientOriginalExtension();
            $brochureName = uniqid() . '.' . $ext;
            $projectBrochure->move(public_path('/Offices/Projects/pdfs'), $brochureName);
            $project_data['project_brochure'] = '/Offices/Projects/pdfs/' . $brochureName;
        }


        unset($project_data['time_line']);
        unset($project_data['date']);

        if ($images) {
            $project->ProjectImages()->delete();
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Offices/Projects/', $ext);
                ProjectImage::create([
                    'image' => '/Offices/Projects/' . $ext,
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

        if ($old_project->show_in_gallery == 0 && $project->show_in_gallery == 1) {
            $this->MailUnitPublished($project);
            $this->WhatsappUnitPublished($project);
        }
        return $project;
    }


    function ShowProject($id)
    {
        return Project::find($id);
    }

    public function delete($id)
    {
        return Project::destroy($id);
    }

    public function storeProperty($data, $images)
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
                $image->move(public_path() . '/Offices/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Offices/Projects/Property/' . $ext,
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
        $unit_data['office_id'] = Auth::user()->UserOfficeData->id;
        $unit_data['project_id'] = $id;
        $license_date = auth()->user()->UserOfficeData->license_date;

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

        return redirect()->route('Office.Project.index')->with('success', __('added successfully'));
    }

    public function autocomplete($data)
    {
        return Feature::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $data['search'] . '%')
            ->get();
    }
}
