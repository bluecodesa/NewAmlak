<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Models\EmailTemplate;
use App\Models\NotificationSetting;
use App\Services\Admin\SettingService;
use App\Services\Admin\EmailSettingService;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    protected $settingRepo;
    protected $settingService;
    protected $paymentGateway;
    protected $EmailSettingService;

    public function __construct(
        SettingRepositoryInterface $settingRepo,
        SettingService $settingService,
        EmailSettingService $EmailSettingService,
        PaymentGatewayRepositoryInterface $paymentGateway
    ) {
        $this->settingRepo = $settingRepo;
        $this->settingService = $settingService;
        $this->paymentGateway = $paymentGateway;
        $this->EmailSettingService = $EmailSettingService;
    }

    public function index()
    {
        $settings = $this->settingRepo->getAllSetting();
        $EmailSettingService = $this->EmailSettingService->getAll();
        $NotificationSetting = $this->settingRepo->getNotificationSetting();
        $paymentGateways = $settings->paymentGateways;
        return view('Admin.settings.index', get_defined_vars());
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

    public function update(Request $request, Setting $setting)
    {
        $this->settingService->updateSetting($request, $setting);

        return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }


    public function destroy(string $id)
    {
    }

    public function editPaymentGatewayForm($id)
    {
        return $this->paymentGateway->editPaymentGatewayForm($id);
    }


    public function createPaymentGateway(Request $request)
    {
        $this->paymentGateway->createPaymentGateway($request->all());
        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway updated successfully.'));
    }

    public function updatePaymentGateway(Request $request, $id)
    {
        $this->paymentGateway->updatePaymentGateway($id, $request->all());

        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway updated successfully.'));
    }

    public function updateTax(Request $request, Setting $setting)
    {
        $this->validate($request, [
            'tax_rate' => 'nullable|numeric|min:1|max:100',
        ]);

        $taxRate = $request->input('tax_rate') / 100;
        $setting->tax_rate = $taxRate;
        $setting->save();

        return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }

    function NotificationSetting(Request $request, $id)
    {
        $this->settingService->NotificationToggleSetting($request, $id);
    }

    function UpdateEmailSetting(Request $request)
    {
        $this->settingService->UpdateEmailSetting($request->all());
        return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }
    function EditEmailTemplate($id)
    {
        return view('Admin.settings.Notification.edit', get_defined_vars());
    }
}
