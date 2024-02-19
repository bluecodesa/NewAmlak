<?php

namespace App\Services\Admin;


use App\Repositories\Admin\SettingRepository;
use Illuminate\Http\Request;
use App\Interfaces\Admin\SettingRepositoryInterface;


class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getSettings()
    {
        return $this->settingRepository->getSettings();
    }

    public function updateSettings($request, $id)
    {
        return $this->settingRepository->updateSettings($request, $id);
    }
}
