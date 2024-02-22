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
        $setting =  Setting::first(); // Assuming you have only one setting
        $setting->update([
            'active_home_page' => $request->active_home_page,
        ]);
        // You might want to add some validation and error handling here
    }

    public function create()
    {
        // Add your create logic here if needed
    }

    public function store(Request $request)
    {
        // Add your store logic here if needed
    }

    public function show(string $id)
    {
        // Add your show logic here if needed
    }

    public function edit(string $id)
    {
        // Add your edit logic here if needed
    }

    public function update(Request $request, Setting $setting)
    {
        // Add your update logic here
    }

    public function destroy(string $id)
    {
        // Add your destroy logic here if needed
    }

    public function editPaymentGatewayForm($id)
    {
        $paymentGateway = PaymentGateway::find($id);
        return view('Admin.settings.Payments.edit-modal', compact('paymentGateway'));
    }

    public function createPaymentGateway(Request $request)
    {
        // Add your create payment gateway logic here
    }

    public function updatePaymentGateway(Request $request, $id)
    {
        // Add your update payment gateway logic here
    }
}
