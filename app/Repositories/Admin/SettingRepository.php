<?php

namespace App\Repositories\Admin;
use App\Models\Setting;
use App\Interfaces\Admin\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function getSettings()
    {
        return Setting::first();
    }

    public function updateSettings($request, $id)
    {
        $setting = Setting::findOrFail($id);

        foreach (config('translatable.locales') as $locale) {
            $setting->translateOrNew($locale)->title = $request->input("$locale.title");
        }

        $setting->facebook = $request->input('url');

        if ($request->hasFile('icon')) {
            if ($setting->icon) {
                $previousIconPath = public_path($setting->icon);
                if (file_exists($previousIconPath)) {
                    unlink($previousIconPath);
                }
            }
            $file = $request->file('icon');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('logos');
            $file->move($destinationPath, $fileName);
            $setting->icon = 'logos/' . $fileName;
        }

        $setting->color = $request->input('color');

        $setting->save();

        return $setting;
    }
}
