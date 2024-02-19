<?php


namespace App\Interfaces\Admin;

interface SettingRepositoryInterface
{
    public function getSettings();

    public function updateSettings($request, $id);
}
