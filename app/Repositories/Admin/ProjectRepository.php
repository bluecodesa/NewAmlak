<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ProjectRepositoryInterface;
use App\Models\DeliveryCase;
use App\Models\ProjectStatus;


class ProjectRepository implements ProjectRepositoryInterface
{


    public function getAllProjectStatus(){
        return ProjectStatus::paginate(100);

    }
    public function createProjectStatu($data){
        return ProjectStatus::create($data);

    }
    public function getProjectStatuById($id){
        return ProjectStatus::find($id);

    }
    public function updateProjectStatu($id, $data){
        $Section = ProjectStatus::findOrFail($id);
        $Section->update($data);
        return $Section;
    }
    public function deleteProjectStatus($id){
        return ProjectStatus::findOrFail($id)->delete();

    }

    public function getAllDeliveryCases(){
        return DeliveryCase::paginate(100);

    }
    public function createDeliveryCase($data){
        return DeliveryCase::create($data);

    }
    public function getDeliveryCaseById($id){
        return DeliveryCase::find($id);

    }
    public function updateDeliveryCase($id, $data){
        $Section = DeliveryCase::findOrFail($id);
        $Section->update($data);
        return $Section;
    }
    public function deleteDeliveryCase($id){
        return DeliveryCase::findOrFail($id)->delete();

    }

}
