<?php


namespace App\Services\Admin;

use App\Models\Setting;
use App\Interfaces\Admin\SettingRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getAllSetting()
    {
        return $this->settingRepository->getAllSetting();
    }


    public function updateSetting(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'ar.title' => 'required|string',
            'en.title' => 'required|string',
            'facebook' => 'nullable|url',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color' => 'nullable|string',
        ]);

        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['title'] = $request->input("$locale.title");
        }

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('logos');
            $file->move($destinationPath, $fileName);
            $data['icon'] = 'logos/' . $fileName;
        }

        $this->settingRepository->updateSetting($setting, $data);

        return $setting;
    }
}
