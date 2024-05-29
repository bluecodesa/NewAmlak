<?php

namespace App\Interfaces\Admin;
use App\Models\TicketResponse;


interface ProjectRepositoryInterface
{
    public function getAllProjectStatus();
    public function createProjectStatu($data);
    public function getProjectStatuById($data);
    public function updateProjectStatu($id, $data);
    public function deleteProjectStatus($id);

    public function getAllDeliveryCases();
    public function createDeliveryCase($data);
    public function getDeliveryCaseById($data);
    public function updateDeliveryCase($id, $data);
    public function deleteDeliveryCase($id);




}
