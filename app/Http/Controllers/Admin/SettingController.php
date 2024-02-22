<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Services\Admin\SettingService;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\PaymentGateway;


class SettingController extends Controller
{
    protected $settingRepo;
    protected $settingService;


    public function __construct(SettingRepositoryInterface $settingRepo,SettingService $settingService)
    {
        $this->settingRepo = $settingRepo;
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingRepo->getAllSetting();
        $paymentGateways = $settings->paymentGateways;
        return view('Admin.settings.index',get_defined_vars());
    }

    public function ChangeActiveHomePage(Request $request)
    {
       return $this->settingRepo->ChangeActiveHomePage($request);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, Setting $setting){
        $this->settingService->updateSetting($request, $setting);

    return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }

    // public function update(Request $request, Setting $setting)
    // {
    //     $this->settingRepo->updateSetting($setting, $request->all());
    //     return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    // }

    public function destroy(string $id)
    {
    }

    public function editPaymentGatewayForm($id)
    {
        $paymentGateway = PaymentGateway::find($id);
        return view('Admin.settings.Payments.edit-modal', compact('paymentGateway'));
    }

    public function createPaymentGateway(Request $request)
    {
    }

    public function updatePaymentGateway(Request $request, $id)
    {
    }
}
