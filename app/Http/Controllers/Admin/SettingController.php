<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SettingRepositoryInterface;
use Illuminate\Http\Request;
use App\Services\SettingService;
use App\Models\Setting;
use App\Models\PaymentGateway;

class SettingController extends Controller
{
    protected $settingRepo;

    public function __construct(SettingRepositoryInterface $settingRepo)
    {
        $this->settingRepo = $settingRepo;
    }

    public function index()
    {
        $settings = $this->settingRepo->getAllSetting();
        $paymentGateways = $settings->paymentGateways;
        return view('Admin.settings.index',get_defined_vars());
    }

    public function ChangeActiveHomePage(Request $request)
    {
        $setting =  Setting::first();
        $setting->update([
            'active_home_page' => $request->active_home_page,
        ]);
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

    public function update(Request $request, Setting $setting)
    {
    }

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
