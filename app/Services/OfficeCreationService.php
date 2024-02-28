<?php

namespace App\Services;

use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewOfficeNotification;


class OfficeCreationService
{
    public function createOffice(array $officeData, User $user)
    {
        $office = Office::create([
            'user_id' => $user->id,
            'CRN' => $officeData['CRN'],
            'company_name' => $user->name,
            'city_id' => $officeData['city_id'],
            'created_by' => Auth::id(),
            'presenter_name' => $officeData['presenter_name'],
            'presenter_number' => $officeData['presenter_number'],
            'company_logo' => $officeData['company_logo'],
        ]);

        // Notify admins about the new office
        $this->notifyAdmins($office);

        return $office;
    }

    protected function notifyAdmins(Office $office)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewOfficeNotification($office));
        }
    }
}
