<?php

namespace App\Repositories\Office;

use App\Models\Advisor;

class AdvisorRepository
{
    public function getAllAdvisorsForOffice($officeId)
    {
        return Advisor::where('office_id', $officeId)->get();
    }

    public function createAdvisor($data)
    {
        return Advisor::create($data);
    }

    function getAdvisorById($id)
    {
        return Advisor::find($id);
    }

    public function updateAdvisor($id, $data)
    {
        $advisor = Advisor::findOrFail($id);
        $advisor->update($data);
        return $advisor;
    }

    public function deleteAdvisor($id)
    {
        return Advisor::findOrFail($id)->delete();
    }
}
