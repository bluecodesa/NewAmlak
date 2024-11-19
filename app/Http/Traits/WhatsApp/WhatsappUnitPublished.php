<?php
namespace App\Http\Traits\WhatsApp;

use App\Models\WhatsAppSetting;
use App\Models\WhatsappTemplate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

trait WhatsappUnitPublished
{
    public function WhatsappUnitPublished($unit)
    {
        $whatsAppSetting = WhatsAppSetting::first();

        $notification_id = DB::table('notification_settings')
            ->where('notification_name', 'unit_published')
            ->where('whatsapp', 1)
            ->value('id');

        $whatsappTemplate = WhatsappTemplate::where('notification_setting_id', $notification_id)->first();

        if (!$whatsAppSetting) {
            return 'No WhatsApp settings found for this user';
        }

        if ($whatsappTemplate) {
            // تنظيف وتهيئة المحتوى للاستخدام في WhatsApp
            $plainContent = strip_tags($whatsappTemplate->content, '<br><p>');
            $plainContent = preg_replace('/<br\s*\/?>/i', "\n", $plainContent);
            $plainContent = preg_replace('/<\/p>/i', "\n\n", $plainContent);
            $plainContent = preg_replace('/<p[^>]*>/i', '', $plainContent);
            $plainContent = html_entity_decode($plainContent);

            // إعداد البيانات التي سيتم استبدالها
            $data['variable_home'] = env('APP_URL');
            $data['variable_login'] = route('Admin.home');
            $data['variable_owner_name'] = $unit->OwnerData->name ?? null;
            $data['city'] = $unit->CityData->name ?? null;
            $data['district'] = $unit->DistrictData->name ?? null;
            $data['variable_broker_name'] = $unit->OfficeData->UserData->name ?? $unit->BrokerData->UserData->name ?? '';
            $data['property_type_data_name'] = $unit->PropertyTypeData->name ?? $unit->name;

            // استبدال المتغيرات في النص
            foreach ($data as $key => $value) {
                // قم باستبدال المتغيرات داخل النص
                $placeholder = '$data[' . $key . ']';
                $plainContent = str_replace($placeholder, $value, $plainContent);
            }

            // إرسال الرسالة باستخدام API الخاص بـ WhatsApp
            $phone = $unit->OfficeData->UserData->full_phone ?? $unit->BrokerData->UserData->full_phone ?? '';

            $client = new Client();

            try {
                $response = $client->post(
                    $whatsAppSetting->url,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $whatsAppSetting->api_key,
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ],
                        'json' => [
                            'session_uuid' => $whatsAppSetting->session_uuid,
                            'phone' => 201119978333, // تأكد من استخدام الرقم الصحيح
                            // 'phone' => $phone, // تأكد من استخدام الرقم الصحيح
                            'type' => $whatsAppSetting->type,
                            'message' => $plainContent, // استخدم المحتوى المعدل هنا
                            'schedule_at' => now(),
                        ],
                    ]
                );

                return $response->getBody()->getContents();
            } catch (\Throwable $th) {
                // معالجة الأخطاء التي قد تحدث
                return 'Error sending WhatsApp message: ' . $th->getMessage();
            }
        }


    }
}
