<?php

namespace App\Services\Broker;

use App\Models\InterestTypeTranslation;
use App\Models\UnitInterest;
use App\Models\User;
use App\Notifications\Admin\NewIntrestOrderNotification;
use App\Repositories\Broker\UnitInterestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class UnitInterestService
{
    protected $unitInterestRepository;

    public function __construct(UnitInterestRepository $unitInterestRepository)
    {
        $this->unitInterestRepository = $unitInterestRepository;
    }

    public function index(Request $request)
    {
        return $this->unitInterestRepository->index($request);
    }

    public function create(array $data)
    {
        return $this->unitInterestRepository->create($data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'user_id' => 'required|exists:users,id',
        ]);


        $statusId = InterestTypeTranslation::where('name', 'new order')->value('id');

        $requestData = $request->all();
        $requestData['status'] = $statusId;
        $unitInterest = $this->unitInterestRepository->create($requestData);

        $this->notifyAdmins($unitInterest);

        return $unitInterest;
    }

    protected function notifyAdmins(UnitInterest $unitInterest)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewIntrestOrderNotification($unitInterest));
        }
    }
    public function find(string $id)
    {
        return $this->unitInterestRepository->find($id);
    }

    public function update(Request $request, string $id)
    {
        return $this->unitInterestRepository->update($request, $id);
    }

    public function destroy(string $id)
    {
        $this->unitInterestRepository->destroy($id);
    }
    public function getNumberOfInterests()
    {
        return $this->unitInterestRepository->getNumberOfInterests();
    }

    public function getUnitInterestsByUnitId($id)
    {
        return  $this->unitInterestRepository->getUnitInterestsByUnitId($id);
    }
}
