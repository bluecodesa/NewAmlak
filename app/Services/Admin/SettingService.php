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

    /**
     * Get the first setting from the database.
     *
     * @return Setting|null
     */
    public function getAllSetting(): Setting
    {
        return $this->settingRepository->getAllSetting();
    }

    /**
     * Update the setting with the provided data.
     *
     * @param array $data
     * @param Setting $setting
     * @return Setting
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateSetting(array $data, Setting $setting): Setting
    {
        // Validation rules
        $rules = [
            'ar.title' => 'required|string',
            'en.title' => 'required|string',
            'facebook' => 'nullable|url',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color' => 'nullable|string',
        ];

        // Validate the input data
        $validator = Validator::make($data, $rules);
        $validator->validate();

        // Update the setting with the provided data
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

        // Save the updated setting
        $this->settingRepository->updateWebsiteSetting($setting);

        return $setting;
    }
}
