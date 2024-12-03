<?php

namespace App\Repositories\Office;

use App\Models\UnitInterest;
use App\Interfaces\Office\UnitInterestRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\Admin\NewIntrestOrderNotification;

class UnitInterestRepository implements UnitInterestRepositoryInterface
{
    public function index(Request $request)
    {
        $userId = auth()->user()->UserOfficeData->user_id;

        $statusFilter = $request->input('status_filter', 'all');
        $propFilter = $request->input('prop_filter', 'all');
        $unitFilter = $request->input('unit_filter', 'all');
        $projectFilter = $request->input('prj_filter', 'all');
        $clientFilter = $request->input('client_filter', 'all');

        $unitInterests = $this->getFilteredUnitInterests(
            $userId,
            $statusFilter,
            $propFilter,
            $unitFilter,
            $projectFilter,
            $clientFilter
        );

        return $unitInterests;
    }

    public function create(array $data)
    {
        return UnitInterest::create($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $unitInterest = $this->create($request->all());

        // $this->notifyAdmins($unitInterest);

        return $unitInterest;
    }

    public function show(string $id)
    {
        return UnitInterest::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $unitInterest = UnitInterest::findOrFail($id);
        $unitInterest->update($request->all());
        return $unitInterest;
    }

    public function destroy(string $id)
    {
        $unitInterest = UnitInterest::findOrFail($id);
        $unitInterest->delete();
    }

    public function getFilteredUnitInterests($userId, $statusFilter, $propFilter, $unitFilter, $projectFilter, $clientFilter)
    {
        $query = UnitInterest::with('unit', 'user')->where('user_id', $userId);

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($propFilter !== 'all') {
            $query->where('property_id', $propFilter);
        }

        if ($unitFilter !== 'all') {
            $query->where('unit_id', $unitFilter);
        }

        if ($projectFilter !== 'all') {
            $query->whereHas('unit.PropertyData', function ($q) use ($projectFilter) {
                $q->where('project_id', $projectFilter);
            });
        }

        if ($clientFilter !== 'all') {
            $query->where('id', $clientFilter);
        }

        return $query->get();
    }

    protected function notifyAdmins(UnitInterest $unitInterest)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewIntrestOrderNotification($unitInterest));
        }
    }


    public function getNumberOfInterests()
    {
        return UnitInterest::where('user_id', auth()->user()->id)->count();
    }

    public function getUnitInterestsByUnitId($id)
    {
        return UnitInterest::where('unit_id', $id)->get();
    }

    public function checkUnitInterestExists(int $interestedId, int $unitId): bool
    {
        return UnitInterest::where(['interested_id' => $interestedId, 'unit_id' => $unitId])->exists();
    }
}
