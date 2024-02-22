<?php


namespace App\Services\Admin;

use App\Models\Setting;
use App\Interfaces\Admin\SettingRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getAllSetting(): Setting
    {
        return $this->settingRepository->getAllSetting();
    }


    public function updateSetting(array $data, Setting $setting): Setting
    {
        $rules = [
            'ar.title' => 'required|string',
            'en.title' => 'required|string',
            'facebook' => 'nullable|url',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color' => 'nullable|string',
        ];

        $validator = Validator::make($data, $rules);
        $validator->validate();

        foreach (config('translatable.locales') as $locale) {
            $setting->translateOrNew($locale)->title = $data["$locale.title"];
        }

        $setting->facebook = $data['facebook'];

        if (isset($data['icon']) && $data['icon']->isValid()) {
            $file = $data['icon'];
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('logos');
            $file->move($destinationPath, $fileName);
            $setting->icon = 'logos/' . $fileName;
        }

        $setting->color = $data['color'];

        $this->settingRepository->updateWebsiteSetting($data,$setting);

        return $setting;
    }
}
