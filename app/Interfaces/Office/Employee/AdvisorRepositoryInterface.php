<?php


namespace App\Interfaces\Office;

interface AdvisorRepositoryInterface
{
    public function getAllAdvisorsForOffice($officeId);

    public function createAdvisor($data);

    public function getAdvisorById($id);

    public function updateAdvisor($id, $data);

    public function deleteAdvisor($id);
}
