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
            'terms_pdf' => 'nullable|file',
            'privacy_pdf' => 'nullable|file',
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

        if ($request->hasFile('terms_pdf')) {
            $termsPdfFile = $request->file('terms_pdf');
            $termsPdfFileName = $termsPdfFile->getClientOriginalName();
            $termsPdfDestinationPath = public_path('pdfs');
            $termsPdfFile->move($termsPdfDestinationPath, $termsPdfFileName);
            $data['terms_pdf'] = 'pdfs/' . $termsPdfFileName;
        }

        if ($request->hasFile('privacy_pdf')) {
            $privacyPdfFile = $request->file('privacy_pdf');
            $privacyPdfFileName = $privacyPdfFile->getClientOriginalName();
            $privacyPdfDestinationPath = public_path('pdfs');
            $privacyPdfFile->move($privacyPdfDestinationPath, $privacyPdfFileName);
            $data['privacy_pdf'] = 'pdfs/' . $privacyPdfFileName;
        }

        $this->settingRepository->updateSetting($setting, $data);

        return $setting;
    }

    function NotificationToggleSetting($data, $id)
    {
        $this->settingRepository->NotificationToggleSetting($data, $id);
    }

    function UpdateEmailSetting($data)
    {
        $this->settingRepository->UpdateEmailSetting($data);
    }
}