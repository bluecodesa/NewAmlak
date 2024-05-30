<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\ProjectRepositoryInterface;
use App\Models\Feature;
use App\Models\Project;
use App\Models\ProjectTimeLine;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Unit;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitRentalPrice;
use App\Models\UnitService;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllByBrokerId($brokerId)
    {
        return Project::where('broker_id', $brokerId)->get();
    }

    public function create($data, $files)
{
    $project_data = $data;

    if (isset($files['image'])) {
        $image = $files['image'];
        $ext = $image->getClientOriginalExtension();
        $imageName = uniqid() . '.' . $ext;
        $image->move(public_path('/Brokers/Projects/'), $imageName);
        $project_data['image'] = '/Brokers/Projects/' . $imageName;
    } else {
        $project_data['image'] = '/Brokers/Projects/default.svg';
    }

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


    unset($project_data['time_line']);
    unset($project_data['date']);

    $project = Project::create($project_data);
    if (isset($data['time_line'])) {
        foreach ($data['time_line'] as $index => $timeLine) {
            // Access the 'status_id' and 'delivery_id' values from the $timeLine array
            $statusId = isset($timeLine['status_id']) ? $timeLine['status_id'] : null;
            $deliveryId = isset($timeLine['delivery_id']) ? $timeLine['delivery_id'] : null;
            $date = isset($data['date'][$index]) ? $data['date'][$index] : null;

            // Create the timeline entry with the correct status and delivery IDs
            ProjectTimeLine::create([
                'status_id' => $statusId,
                'delivery_id' => $deliveryId,
                'project_id' => $project->id,
                'date' => $date
            ]);
        }
    }

    return $project;
}


    public function update($id, $data, $images)
    {
        $project = Project::findOrFail($id);
        if ($images) {
            $ext = $images->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $images->move(public_path('/Brokers/Projects/'), $imageName);
            $data['image'] = '/Brokers/Projects/' . $imageName;
            // } else {
            // $data['image'] = '/Brokers/Projects/default.svg';
        }
        $project->update($data);
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

    public function storeProperty($data, $id, $images)
    {
        $property =  Property::create($data);
        if ($images) {
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() .  '/Brokers/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' =>  '/Brokers/Projects/Property/' . $ext,
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
        if (isset($data['show_gallery'])) {
            if ($data['show_gallery'] == 'on') {
                $unit_data['show_gallery'] = 1;
            } else {
                $unit_data['show_gallery'] = 0;
            }
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
                    $image->move(public_path() . '/Brokers/Projects/Property/Unit', $ext);
                    UnitImage::create([
                        'image' => '/Brokers/Projects/Property/Unit/' . $ext,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }

        return redirect()->route('Broker.Project.index')->with('success', __('added successfully'));
    }

    public function autocomplete($data)
    {
        return Feature::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $data['search'] . '%')
            ->get();
    }

}
