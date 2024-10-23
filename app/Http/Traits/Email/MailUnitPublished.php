<?php

namespace App\Http\Traits\Email;

use App\Email\Admin\UnitPublished;
use App\Email\Admin\WelcomeBroker;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

trait MailUnitPublished
{
    public function MailUnitPublished($unit)
    {

        $notification_id = DB::table('notification_settings')
        ->where('notification_name', 'unit_published')
        ->where('email', 1)
        ->value('id');
        $EmailTemplate =  EmailTemplate::where('notification_setting_id', $notification_id)->first();
        if ($EmailTemplate) {
            $subject =  $EmailTemplate->subject;
            $data['variable_home'] = env('APP_URL');
            $data['variable_login'] = route('Admin.home');
            $data['variable_owner_name'] = $unit->OwnerData->name ?? null;
            $data['city'] = $unit->CityData->name ?? null;
            $data['district'] = $unit->DistrictData->name ?? null;
            $data['variable_broker_name'] = $unit->OfficeData->UserData->name ?? $unit->BrokerData->UserData->name ?? '';
            $data['property_type_data_name'] =  $unit->PropertyTypeData->name ?? $unit->name;
            $content = $EmailTemplate->content;
            $email = $unit->OwnerData->email;
            foreach ($data as $key => $value) {
                $placeholder = '$data[' . $key . ']';
                $content = str_replace($placeholder, $value, $content);
            }
            try {
                Mail::to($email)->send(new UnitPublished($data, $content, $subject, $EmailTemplate));
            } catch (\Throwable $th) {
            }
        }
    }
}
